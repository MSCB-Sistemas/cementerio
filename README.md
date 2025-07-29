# Sistema de Gestión Cementerio Municipal

  ## :memo: Objetivos del proyecto

  El software desarrollado, se enfocará en la administración, registro de personas fallecidas, locaciones y pagos en el contexto del Cementerio Municipal de la ciudad de San Carlos de Bariloche. Esto incluye la gestión de locaciones de parcelas, pagos y vencimientos, orientaciones, reportes, estadísticas y otros atributos asociados.
  Dará solución a la tarea de gestionar los espacios que conforman el Cementerio Municipal, como oficinas de atención al público, ubicaciones de parcelas, etc. Además de brindar estadísticas, registros generales y notificaciones.
  
  ## :hammer_and_wrench: Desarrollo del proyecto

  La aplicación web brinda una plataforma moderna para la gestión cotidiana del cementerio municipal, mejorando la atención mediante la automatización de procesos básicos.

  - Gestión de Difuntos
  - Gestión de Deudos
  - Gestión de Ubicaciones
  - Gestión de Pagos
  - Consultas y Listados

  ## :file_folder: Carpetas 

   - ***mvc_cementerio:*** contiene el código fuente con la estructura Modelo - Vista - Controlador
   - ***db:*** contiene las bases de datos 
   - ***docs:*** contiene la documentación del proyecto
  
  ## Diagrama de base de datos:
  ```mermaid
erDiagram
    deudo {
        int id_deudo PK
        int dni
        string nombre
        int telefono
        string email
        string domicilio
        string localidad
        string codigo_postal
    }

    pago {
        int id_pago PK
        int id_deudo FK
        int id_parcela FK
        date fecha_pago
        int numero_recibo
        int importe
        int recargo
        int total 
    }

    difunto {
        int id_difunto PK
        int id_deudo FK
        string nombre
        string apellido
        int dni
        int edad
        date fecha_fallecimiento
        int sexo FK
        int nacionalidad FK
        int estado_civil FK
        string domicilio
        string localidad
        string codigo_postal
    }

    estado_civil {
        int id_estado_civil PK
        string descripcion
    }

    nacionalidades {
        int id_nacionalidad PK
        string nacionalidad
    }

    sexo {
        int id_sexo PK
        string descripcion
    }

    orientacion {
        int id_orientacion PK
        string descripcion
    }

    parcela {
        int id_parcela PK
        int id_tipo FK
        int id_deudo FK
        int numero_ubicacion
        string hilera
        string seccion
        string fraccion
        int nivel
        string orientacion FK
    }

    ubicacion_difunto {
        int id_ubicacion_difunto PK
        int id_parcela FK
        int id_difunto FK
        date fecha_ingreso
        date fecha_retiro
    }

    tipo_parcela {
        int id_tipo PK
        string nombre_parcela
    }

    deudo ||--o{ difunto : "fk_id_deudo"
    deudo ||--o{ pago : "fk_id_deudo"
    parcela ||--o{ pago : "fk_id_parcela"
    parcela ||--o{ deudo : "fk_id_deudo"
    parcela ||--o{ ubicacion_difunto : "fk_id_parcela"
    difunto ||--o{ ubicacion_difunto : "fk_id_difunto"
    parcela ||--o{ tipo_parcela : "fk_id_tipo"
    difunto ||--o{ estado_civil : "fk_id_estado_civil"
    difunto ||--o{ nacionalidades : "fk_id_nacionalidad"
    difunto ||--o{ sexo : "fk_id_sexo"
    parcela ||--o{ orientacion : "fk_id_orientacion"
```

