<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("
            CREATE TRIGGER `actualizador_de_mantos`
            AFTER UPDATE ON `detalle_venta`
            FOR EACH ROW
            BEGIN
                IF (SELECT COUNT(*) FROM control_de_manto WHERE id_detalle = OLD.id_detalle) = 0 THEN
                    IF NEW.id_plan_manto < 5 THEN
                        INSERT INTO control_de_manto (id_detalle, id_cliente, id_modelo, id_plan_manto, fecha_venta, contador)
                        VALUES (
                            NEW.id_detalle,
                            (SELECT id_cliente FROM venta WHERE id_venta = NEW.id_venta),
                            NEW.id_modelo,
                            NEW.id_plan_manto,
                            (SELECT fecha_venta FROM venta WHERE id_venta = NEW.id_venta),
                            0
                        );
                    END IF;
                ELSE
                    IF NEW.id_plan_manto = 5 THEN
                        DELETE FROM control_de_manto WHERE id_detalle = OLD.id_detalle;
                    ELSE
                        UPDATE control_de_manto
                        SET id_modelo = NEW.id_modelo, id_plan_manto = NEW.id_plan_manto
                        WHERE id_detalle = OLD.id_detalle;
                    END IF;
                END IF;
            END;
        ");

        DB::unprepared("
            CREATE TRIGGER `actualizar_proximo_manto`
            AFTER UPDATE ON `detalle_check`
            FOR EACH ROW
            BEGIN
                IF NEW.id_estado = 2 THEN
                    UPDATE `control_de_manto`
                    SET `fecha_venta` = NEW.fecha_manto, `contador` = `contador` + 1
                    WHERE `id_control_manto` = NEW.id_control_manto;
                ELSEIF NEW.id_estado = 3 THEN
                    UPDATE `control_de_manto`
                    SET `proximo_manto` = NEW.fecha_manto, `fecha_venta` = NULL
                    WHERE `id_control_manto` = NEW.id_control_manto;
                ELSEIF NEW.id_estado = 4 THEN
                    UPDATE `control_de_manto`
                    SET `fecha_venta` = NULL, `proximo_manto` = NULL
                    WHERE `id_control_manto` = NEW.id_control_manto;
                END IF;
            END;
        ");

        DB::unprepared("
            CREATE TRIGGER `calculador_de_fechas`
            BEFORE INSERT ON `control_de_manto`
            FOR EACH ROW
            BEGIN
                IF NEW.fecha_venta IS NOT NULL THEN
                    IF NEW.id_plan_manto = 1 THEN
                        SET NEW.proximo_manto = DATE_ADD(NEW.fecha_venta, INTERVAL 2 MONTH);
                    ELSEIF NEW.id_plan_manto = 2 THEN
                        SET NEW.proximo_manto = DATE_ADD(NEW.fecha_venta, INTERVAL 3 MONTH);
                    ELSEIF NEW.id_plan_manto = 3 THEN
                        SET NEW.proximo_manto = DATE_ADD(NEW.fecha_venta, INTERVAL 4 MONTH);
                    ELSEIF NEW.id_plan_manto = 4 THEN
                        SET NEW.proximo_manto = DATE_ADD(NEW.fecha_venta, INTERVAL 6 MONTH);
                    ELSE
                        SET NEW.proximo_manto = NULL;
                    END IF;
                END IF;
            END;
        ");

        DB::unprepared("
            CREATE TRIGGER `calcular_nueva_fecha`
            BEFORE UPDATE ON `control_de_manto`
            FOR EACH ROW
            BEGIN
                IF NEW.fecha_venta IS NOT NULL THEN
                    IF NEW.id_plan_manto = 1 THEN
                        SET NEW.proximo_manto = DATE_ADD(NEW.fecha_venta, INTERVAL 2 MONTH);
                    ELSEIF NEW.id_plan_manto = 2 THEN
                        SET NEW.proximo_manto = DATE_ADD(NEW.fecha_venta, INTERVAL 3 MONTH);
                    ELSEIF NEW.id_plan_manto = 3 THEN
                        SET NEW.proximo_manto = DATE_ADD(NEW.fecha_venta, INTERVAL 4 MONTH);
                    ELSEIF NEW.id_plan_manto = 4 THEN
                        SET NEW.proximo_manto = DATE_ADD(NEW.fecha_venta, INTERVAL 6 MONTH);
                    ELSE
                        SET NEW.proximo_manto = NULL;
                    END IF;
                END IF;
            END;
        ");

        DB::unprepared("
            CREATE TRIGGER `insertador_de_mantos`
            AFTER INSERT ON `detalle_venta`
            FOR EACH ROW
            BEGIN
                IF NEW.id_plan_manto < 5 THEN
                    INSERT INTO control_de_manto (id_detalle, id_cliente, id_modelo, id_plan_manto, fecha_venta, contador)
                    VALUES (
                        NEW.id_detalle,
                        (SELECT id_cliente FROM venta WHERE id_venta = NEW.id_venta),
                        NEW.id_modelo,
                        NEW.id_plan_manto,
                        (SELECT fecha_venta FROM venta WHERE id_venta = NEW.id_venta),
                        0
                    );
                END IF;
            END;
        ");

        DB::unprepared("
            CREATE TRIGGER `registrar_historial`
            AFTER UPDATE ON `detalle_check`
            FOR EACH ROW
            BEGIN
                INSERT INTO historial_manto (
                    id_detalle_check,
                    id_control_manto,
                    id_estado,
                    fecha_programada,
                    contador,
                    observaciones
                )
                VALUES (
                    NEW.id_detalle_check,
                    NEW.id_control_manto,
                    NEW.id_estado,
                    NEW.fecha_manto,
                    (SELECT contador FROM control_de_manto WHERE id_control_manto = NEW.id_control_manto),
                    NEW.observaciones
                );
            END;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS actualizador_de_mantos');
        DB::unprepared('DROP TRIGGER IF EXISTS actualizar_proximo_manto');
        DB::unprepared('DROP TRIGGER IF EXISTS calculador_de_fechas');
        DB::unprepared('DROP TRIGGER IF EXISTS calcular_nueva_fecha');
        DB::unprepared('DROP TRIGGER IF EXISTS insertador_de_mantos');
        DB::unprepared('DROP TRIGGER IF EXISTS registrar_historial');
    }
};
