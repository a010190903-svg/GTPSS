<?php
session_start();

// Inicializar el almacenamiento de tickets en sesión si no existe
if (!isset($_SESSION['tickets'])) {
    $_SESSION['tickets'] = [];
}

$notificacion_mensaje = "";
if (isset($_SESSION['notificacion'])) {
    $notificacion_mensaje = $_SESSION['notificacion'];
    unset($_SESSION['notificacion']);
}
$medicos = [
    // Medicina General / Familiar
    "MED-01" => ["Dr. Alejandro Méndez Ruiz", "Medicina General", "Planta Baja", "Disponible"],
    "MED-02" => ["Dra. Sofía Villalobos Soto", "Medicina General", "Planta Baja", "De Vacaciones"],
    "MED-03" => ["Dr. Carlos Mendoza Castro", "Medicina General", "Planta Baja", "Disponible"],
    "MED-04" => ["Dra. Valeria Gómez Pardo", "Medicina General", "Planta Baja", "Disponible"],
    // Pediatría
    "MED-05" => ["Dra. Mariana Herrera Silva", "Pediatría", "Piso 1", "Disponible"],
    "MED-06" => ["Dr. Fernando Rojas Lugo", "Pediatría", "Piso 1", "De Vacaciones"],
    "MED-07" => ["Dra. Elena Rostova Cruz", "Pediatría", "Piso 1", "Disponible"],
    // Ginecología y Obstetricia
    "MED-08" => ["Dra. Beatriz Fuentes Vega", "Ginecología", "Piso 1", "Disponible"],
    "MED-09" => ["Dr. Ricardo Palacios Ortiz", "Ginecología", "Piso 1", "Disponible"],
    "MED-10" => ["Dra. Claudia Morales Luna", "Ginecología", "Piso 1", "Disponible"],
    // Cardiología
    "MED-11" => ["Dr. Hugo Sánchez Tello", "Cardiología", "Piso 2", "Disponible"],
    "MED-12" => ["Dra. Natalia Riva Palacio", "Cardiología", "Piso 2", "De Vacaciones"],
    // Dermatología
    "MED-13" => ["Dra. Gabriela Esparza Ruiz", "Dermatología", "Piso 2", "Disponible"],
    "MED-14" => ["Dr. Adrián Benítez Leyva", "Dermatología", "Piso 2", "Disponible"],
    // Endocrinología, Gastro, Nutrición, Salud Mental
    "MED-15" => ["Dra. Laura Quiroz Marín", "Endocrinología", "Piso 2", "Disponible"],
    "MED-16" => ["Dr. Manuel Ortega Reyes", "Gastroenterología", "Piso 2", "Disponible"],
    "MED-17" => ["Lic. Paulina Ríos Salgado", "Nutrición Clínica", "Planta Baja", "Disponible"],
    "MED-18" => ["Psic. Amparo Merino Tobar", "Psicología", "Piso 2", "Disponible"],
    "MED-19" => ["Dr. Julián Figueroa Arce", "Psiquiatría", "Piso 2", "Disponible"],
    // Quirúrgicas y Traumatología
    "MED-20" => ["Dr. Javier Peralta Alanís", "Traumatología", "Piso 3", "Disponible"],
    "MED-21" => ["Dr. Mateo Estrada Zavala", "Traumatología", "Piso 3", "De Vacaciones"],
    "MED-22" => ["Dr. Rodrigo Cázares Quintanilla", "Cirugía General", "Piso 3", "Disponible"],
    "MED-23" => ["Dra. Silvia Navarro Pineda", "Otorrinolaringología", "Piso 3", "Disponible"],
    "MED-24" => ["Dr. Emilio Salazar Bravo", "Oftalmología", "Piso 3", "Disponible"],
    "MED-25" => ["Dr. Gonzalo Beltrán Nieto", "Urología", "Piso 3", "Disponible"],
    // Especialidades Complementarias
    "MED-26" => ["Dr. Claudio Vargas Machuca", "Neumología", "Piso 4", "Disponible"],
    "MED-27" => ["Dra. Diana Soler Bahena", "Neurología", "Piso 4", "Disponible"],
    "MED-28" => ["Dra. Mónica Albarrán Trejo", "Reumatología", "Piso 4", "Disponible"],
    "MED-29" => ["Dr. Arturo Del Valle Flores", "Oncología", "Piso 4", "Disponible"],
    "MED-30" => ["Dra. Sandra Luzanía Ocaña", "Rehabilitación Física", "Piso 4", "Disponible"]
];

$servicios = [
    "SERV-01" => "Consulta de Primer Contacto / General - $500.00",
    "SERV-02" => "Consulta Pediátrica - $800.00",
    "SERV-03" => "Consulta Ginecología y Control - $900.00",
    "SERV-04" => "Consulta Cardiología - $1200.00",
    "SERV-05" => "Electrocardiograma (Apoyo Clínico) - $1500.00",
    "SERV-06" => "Consulta Dermatológica - $1000.00",
    "SERV-07" => "Consulta Endocrinología - $1100.00",
    "SERV-08" => "Consulta Gastroenterología - $1100.00",
    "SERV-09" => "Plan Nutricional Clínico - $700.00",
    "SERV-10" => "Sesión Psicoterapia - $600.00",
    "SERV-11" => "Consulta Psiquiatría - $1200.00",
    "SERV-12" => "Consulta Traumatología / Ortopedia - $1000.00",
    "SERV-13" => "Valoración Cirugía General - $1100.00",
    "SERV-14" => "Consulta Otorrinolaringología - $950.00",
    "SERV-15" => "Consulta Oftalmología - $950.00",
    "SERV-16" => "Consulta Urología - $1050.00",
    "SERV-17" => "Consulta Neumología - $1200.00",
    "SERV-18" => "Consulta Neurología - $1300.00",
    "SERV-19" => "Consulta Reumatología - $1200.00",
    "SERV-20" => "Seguimiento Oncológico - $1500.00",
    "SERV-21" => "Terapia Física y Rehabilitación - $600.00"
];

$consultorios = [
    "CONS-PB01" => "Consultorio PB-01 (Planta Baja - Medicina General)",
    "CONS-PB02" => "Consultorio PB-02 (Planta Baja - Medicina General)",
    "CONS-PB03" => "Consultorio PB-03 (Planta Baja - Medicina General)",
    "CONS-PB04" => "Consultorio PB-04 (Planta Baja - Medicina General)",
    "CONS-PB05" => "Consultorio PB-05 (Planta Baja - Medicina General)",
    "CONS-PB06" => "Consultorio PB-06 (Planta Baja - Nutrición)",
    "CONS-101" => "Consultorio 101 (Piso 1 - Pediatría)",
    "CONS-102" => "Consultorio 102 (Piso 1 - Pediatría)",
    "CONS-103" => "Consultorio 103 (Piso 1 - Pediatría)",
    "CONS-104" => "Consultorio 104 (Piso 1 - Ginecología)",
    "CONS-105" => "Consultorio 105 (Piso 1 - Ginecología)",
    "CONS-106" => "Consultorio 106 (Piso 1 - Ginecología)",
    "CONS-201" => "Consultorio 201 (Piso 2 - Cardiología)",
    "CONS-202" => "Consultorio 202 (Piso 2 - Dermatología)",
    "CONS-203" => "Consultorio 203 (Piso 2 - Endocrinología)",
    "CONS-204" => "Consultorio 204 (Piso 2 - Gastroenterología)",
    "CONS-205" => "Consultorio 205 (Piso 2 - Psiquiatría)",
    "CONS-206" => "Consultorio 206 (Piso 2 - Psicología)",
    "CONS-301" => "Consultorio 301 (Piso 3 - Traumatología)",
    "CONS-302" => "Consultorio 302 (Piso 3 - Traumatología)",
    "CONS-303" => "Consultorio 303 (Piso 3 - Cirugía General)",
    "CONS-304" => "Consultorio 304 (Piso 3 - Otorrinolaringología)",
    "CONS-305" => "Consultorio 305 (Piso 3 - Oftalmología)",
    "CONS-306" => "Consultorio 306 (Piso 3 - Urología)",
    "CONS-401" => "Consultorio 401 (Piso 4 - Neumología)",
    "CONS-402" => "Consultorio 402 (Piso 4 - Neurología)",
    "CONS-403" => "Consultorio 403 (Piso 4 - Reumatología)",
    "CONS-404" => "Consultorio 404 (Piso 4 - Oncología)",
    "CONS-405" => "Consultorio 405 (Piso 4 - Rehabilitación Física)",
    "CONS-406" => "Consultorio 406 (Piso 4 - Rehabilitación Física)"
];

$horas_disponibles = [];
for ($h = 8; $h <= 20; $h++) {
    $hora_str = str_pad($h, 2, "0", STR_PAD_LEFT);
    $horas_disponibles[] = "$hora_str:00";
    if ($h != 20) { $horas_disponibles[] = "$hora_str:30"; }
}

$seccion = $_GET['seccion'] ?? 'inicio';

// 2. CONTROL DE LOGIN MULTI-USUARIO
$error_login = "";
$usuarios_autorizados = ['ADM123' => 'Administrador General'];
foreach ($medicos as $key_medico => $datos_medico) {
    $usuarios_autorizados[$key_medico] = $datos_medico[0];
}

if (isset($_POST['login_accion'])) {
    $usuario_ingresado = strtoupper(trim($_POST['usuario'] ?? ''));
    $password_ingresada = trim($_POST['password'] ?? '');

    if (array_key_exists($usuario_ingresado, $usuarios_autorizados) && $password_ingresada === 'adm123') {
        $_SESSION['admin_logged'] = true;
        $_SESSION['usuario_nombre'] = $usuarios_autorizados[$usuario_ingresado];
        $_SESSION['usuario_id'] = $usuario_ingresado;
        header("Location: ?seccion=tickets");
        exit;
    } else {
        $error_login = "Usuario o contraseña incorrectos.";
    }
}

if (isset($_GET['logout'])) {
    unset($_SESSION['admin_logged']);
    unset($_SESSION['usuario_nombre']);
    unset($_SESSION['usuario_id']);
    header("Location: ?seccion=inicio");
    exit;
}

if ($seccion == 'tickets' && (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true)) {
    $seccion = 'inicio';
}

// 3. PROCESAMIENTO DE CITAS Y EDICIÓN (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion_cita']) && $_POST['accion_cita'] === 'crear') {
        $nombre = trim($_POST['nombre'] ?? '');
        $apellido_p = trim($_POST['apellido_p'] ?? '');
        $apellido_m = trim($_POST['apellido_m'] ?? '');
        $nombre_completo = "$nombre $apellido_p $apellido_m";
        $id_medico = $_POST['id_medico'] ?? '';
        $id_servicio = $_POST['id_servicio'] ?? '';
        $id_consultorio = $_POST['id_consultorio'] ?? '';
        $fecha = $_POST['fecha'] ?? '';
        $hora = $_POST['hora'] ?? '';
        $id_turno_simulado = 'T-' . rand(1000, 9999);

        $nuevo_ticket = [
            'id_turno' => $id_turno_simulado,
            'nombre_paciente' => $nombre_completo,
            'id_medico' => $id_medico,
            'id_servicio' => $id_servicio,
            'id_consultorio' => $id_consultorio,
            'fecha' => $fecha,
            'hora' => $hora
        ];

        $_SESSION['tickets'][] = $nuevo_ticket;
        $_SESSION['ultimo_ticket'] = $nuevo_ticket;
        
        header("Location: ?seccion=comprobante");
        exit;
    }

    if (isset($_POST['accion_cita']) && $_POST['accion_cita'] === 'editar') {
        $indice = $_POST['indice_ticket'] ?? '';
        if (isset($_SESSION['tickets'][$indice])) {
            $_SESSION['tickets'][$indice]['fecha'] = $_POST['fecha'];
            $_SESSION['tickets'][$indice]['hora'] = $_POST['hora'];
            $_SESSION['notificacion'] = "Notificacion enviada: La cita del paciente " . $_SESSION['tickets'][$indice]['nombre_paciente'] . " ha sido actualizada correctamente.";
        }
        header("Location: ?seccion=tickets");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservaciones Medicas UVM</title>
    <style>
        :root {
            --azul-marino: #00205B;
            --rojo-uvm: #C8102E;
            --verde-fuerte: #1E5128;
            --blanco: #FFFFFF;
            --gris-claro: #F4F4F4;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: var(--blanco);
            margin: 0;
            padding: 0;
            color: var(--azul-marino);
            font-size: 18px; 
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 20px 40px;
            border-bottom: 5px solid var(--rojo-uvm);
            background-color: var(--gris-claro);
        }

        header h1 { margin: 0; color: var(--azul-marino); font-size: 28px; line-height: 75px; }
        
        .logo-container {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .logo-container img { height: 60px; }

        .header-login {
            margin-top: 8px;
            background: #ffffff;
            padding: 6px 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        nav {
            background-color: var(--azul-marino);
            display: flex;
            justify-content: center;
            gap: 20px;
            padding: 15px;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background 0.3s;
            font-size: 18px;
        }

        nav a:hover, nav a.active {
            background-color: var(--rojo-uvm);
        }

        .contenedor {
            max-width: 1000px;
            margin: 30px auto;
            padding: 35px;
            background-color: var(--gris-claro);
            border-top: 6px solid var(--verde-fuerte);
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,32,91,0.15);
        }

        .hero-banner { text-align: center; margin-bottom: 30px; }
        .hero-banner img {
            width: 100%; max-height: 350px; object-fit: cover; border-radius: 8px; border: 3px solid var(--azul-marino);
        }

        .tarjetas-grid { display: flex; gap: 20px; margin-top: 25px; justify-content: center; }
        .tarjeta {
            flex: 1; max-width: 300px; background: white; padding: 20px; border-radius: 8px; border-left: 5px solid var(--verde-fuerte); box-shadow: 0 2px 8px rgba(0,0,0,0.1); text-align: center;
        }
        .tarjeta h3 { color: var(--azul-marino); margin-top: 0; }
        .btn-card {
            display: inline-block; margin-top: 15px; background-color: var(--azul-marino); color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-weight: bold;
        }
        .btn-card:hover { background-color: var(--rojo-uvm); }

        .campo { margin-bottom: 20px; }
        label { display: block; font-weight: bold; margin-bottom: 8px; color: var(--azul-marino); }
        select, input[type="date"], input[type="text"], input[type="email"], input[type="tel"], input[type="password"] {
            width: 100%; padding: 12px; border: 2px solid var(--azul-marino); border-radius: 6px; background-color: var(--blanco); font-size: 17px; box-sizing: border-box;
        }
        .fila-flex { display: flex; gap: 15px; }
        .fila-flex > div { flex: 1; }

        table { width: 100%; border-collapse: collapse; background: white; margin-top: 15px; border-radius: 6px; overflow: hidden; }
        th, td { padding: 14px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background-color: var(--azul-marino); color: white; }
        .badge-disponible { background-color: #d4edda; color: #155724; padding: 5px 10px; border-radius: 4px; font-weight: bold; }
        .badge-vacaciones { background-color: #f8d7da; color: #721c24; padding: 5px 10px; border-radius: 4px; font-weight: bold; }

        button[type="submit"].btn-grande, .btn-volver {
            background-color: var(--verde-fuerte); 
            color: white; 
            border: none; 
            padding: 22px; 
            width: 100%; 
            font-size: 24px; 
            font-weight: bold; 
            border-radius: 8px; 
            cursor: pointer; 
            margin-top: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            text-align: center;
            text-decoration: none;
            display: block;
            box-sizing: border-box;
            transition: background 0.3s;
        }
        button[type="submit"].btn-grande:hover, .btn-volver:hover { background-color: var(--azul-marino); }
        
        .notificacion-banner {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-weight: bold;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>

    <header>
        <h1>Reservaciones Medicas UVM</h1>
        <div class="logo-container">
            <img src="logo_uvm.png" alt="Logo UVM" onerror="this.outerHTML='<span style=\'color:red;font-size:14px;\'>[Falta logo_uvm.png]</span>'">
            
            <div class="header-login">
                <?php if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true): ?>
                    <form action="" method="POST" style="display: flex; gap: 6px; align-items: center; margin: 0;">
                        <input type="text" name="usuario" placeholder="Usuario (ej. MED-01)" style="padding: 4px 8px; font-size: 13px; width: 140px;" required>
                        <input type="password" name="password" placeholder="Pass (adm123)" style="padding: 4px 8px; font-size: 13px; width: 110px;" required>
                        <button type="submit" name="login_accion" value="1" style="padding: 5px 10px; font-size: 13px; background: var(--azul-marino); color: white; border: none; border-radius: 4px; cursor: pointer;">Entrar</button>
                    </form>
                    <?php if (!empty($error_login)): ?>
                        <div style="color: red; font-size: 11px; margin-top: 2px; text-align: right;"><?php echo $error_login; ?></div>
                    <?php endif; ?>
                <?php else: ?>
                    <span style="font-size: 13px; font-weight: bold; color: var(--verde-fuerte);">
                        Usuario: <?php echo $_SESSION['usuario_nombre']; ?>
                    </span> 
                    <a href="?logout=1" style="color: var(--rojo-uvm); font-weight: bold; text-decoration: none; font-size: 13px; margin-left: 8px;">Cerrar Sesion</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <nav>
        <a href="?seccion=inicio" class="<?php echo ($seccion == 'inicio') ? 'active' : ''; ?>">Inicio</a>
        <a href="?seccion=agendar" class="<?php echo ($seccion == 'agendar') ? 'active' : ''; ?>">Agendar Cita</a>
        <a href="?seccion=medicos" class="<?php echo ($seccion == 'medicos') ? 'active' : ''; ?>">Perfiles y Vacaciones</a>
        <?php if (isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true): ?>
            <a href="?seccion=tickets" class="<?php echo ($seccion == 'tickets') ? 'active' : ''; ?>">Historial de Tickets</a>
        <?php endif; ?>
    </nav>

    <div class="contenedor">

        <?php if (!empty($notificacion_mensaje)): ?>
            <div class="notificacion-banner">
                <?php echo $notificacion_mensaje; ?>
            </div>
        <?php endif; ?>

        <?php if ($seccion == 'inicio'): ?>
            <div class="hero-banner">
                <h2>Bienvenidos al Centro Médico UVM</h2>
                <p>Infraestructura clínica de alta especialidad y control automatizado de turnos.</p>
                <img src="consultorio.jpg" alt="Instalaciones del Consultorio" onerror="this.outerHTML='<div style=\'border: 2px dashed #00205B; padding: 40px; text-align: center; color: #00205B;\'><h3>[Espacio para la Imagen del Consultorio]</h3><p>Coloca un archivo llamado <b>consultorio.jpg</b> en la carpeta del proyecto.</p></div>'">
            </div>

            <div class="tarjetas-grid">
                <div class="tarjeta">
                    <h3>Agendar Citas</h3>
                    <p>Registre pacientes y asigne turnos médicos.</p>
                    <a href="?seccion=agendar" class="btn-card">Ir a Agendar</a>
                </div>
                <div class="tarjeta">
                    <h3>Directorio Médico</h3>
                    <p>Consulte especialistas y vacaciones.</p>
                    <a href="?seccion=medicos" class="btn-card">Ver Doctores</a>
                </div>
                <?php if (isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true): ?>
                <div class="tarjeta">
                    <h3>Zona de Tickets</h3>
                    <p>Supervisión de comprobantes.</p>
                    <a href="?seccion=tickets" class="btn-card">Ver Tickets</a>
                </div>
                <?php endif; ?>
            </div>

        <?php elseif ($seccion == 'agendar'): ?>
            <h2>Agendar Nuevo Turno Médico</h2>
            <form action="" method="POST">
                <input type="hidden" name="accion_cita" value="crear">
                <h3>Datos del Paciente</h3>
                <div class="campo fila-flex">
                    <div><label>Nombre(s):</label><input type="text" name="nombre" required></div>
                    <div><label>Apellido Paterno:</label><input type="text" name="apellido_p" required></div>
                    <div><label>Apellido Materno:</label><input type="text" name="apellido_m" required></div>
                </div>

                <div class="campo fila-flex">
                    <div><label>Fecha de Nacimiento:</label><input type="date" name="fecha_nacimiento" required></div>
                    <div><label>Teléfono:</label><input type="tel" name="telefono" required></div>
                    <div><label>Correo:</label><input type="email" name="correo" required></div>
                </div>

                <h3>Detalles de la Cita</h3>
                <div class="campo">
                    <label>Médico Especialista:</label>
                    <select name="id_medico" required>
                        <option value="">-- Seleccione Médico --</option>
                        <?php foreach($medicos as $id => $info): ?>
                            <?php if($info[3] == 'Disponible'): ?>
                                <option value="<?php echo $id; ?>"><?php echo "{$info[0]} ({$info[1]})"; ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="campo">
                    <label>Servicio Requerido (Catálogo Completo):</label>
                    <select name="id_servicio" required>
                        <option value="">-- Seleccione Servicio --</option>
                        <?php foreach($servicios as $id => $desc) echo "<option value='$id'>$desc</option>"; ?>
                    </select>
                </div>

                <div class="campo">
                    <label>Consultorio Asignado:</label>
                    <select name="id_consultorio" required>
                        <option value="">-- Seleccione Consultorio --</option>
                        <?php foreach($consultorios as $id => $desc) echo "<option value='$id'>$desc</option>"; ?>
                    </select>
                </div>

                <div class="campo fila-flex">
                    <div><label>Fecha:</label><input type="date" name="fecha" required></div>
                    <div><label>Hora:</label>
                        <select name="hora" required>
                            <option value="">-- Hora --</option>
                            <?php foreach($horas_disponibles as $h) echo "<option value='$h'>$h hrs</option>"; ?>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn-grande">Generar Turno y Ver Comprobante</button>
            </form>

        <?php elseif ($seccion == 'comprobante' && isset($_SESSION['ultimo_ticket'])): ?>
            <?php $t = $_SESSION['ultimo_ticket']; ?>
            <div style="background: white; color: #333; padding: 30px; border-radius: 10px; border-left: 10px solid var(--verde-fuerte); text-align: center;">
                <h2 style="color: var(--rojo-uvm); margin-top: 0;">Comprobante de Turno Generado</h2>
                <div style="font-size: 19px; margin: 12px 0; border-bottom: 1px dashed #ccc; padding-bottom: 8px; text-align: left;"><strong>ID Turno:</strong> <?php echo $t['id_turno']; ?></div>
                <div style="font-size: 19px; margin: 12px 0; border-bottom: 1px dashed #ccc; padding-bottom: 8px; text-align: left;"><strong>Paciente:</strong> <?php echo htmlspecialchars($t['nombre_paciente']); ?></div>
                <div style="font-size: 19px; margin: 12px 0; border-bottom: 1px dashed #ccc; padding-bottom: 8px; text-align: left;"><strong>Médico:</strong> <?php echo $medicos[$t['id_medico']][0] ?? 'N/A'; ?></div>
                <div style="font-size: 19px; margin: 12px 0; border-bottom: 1px dashed #ccc; padding-bottom: 8px; text-align: left;"><strong>Servicio:</strong> <?php echo $servicios[$t['id_servicio']] ?? 'N/A'; ?></div>
                <div style="font-size: 19px; margin: 12px 0; border-bottom: 1px dashed #ccc; padding-bottom: 8px; text-align: left;"><strong>Ubicación:</strong> <?php echo $consultorios[$t['id_consultorio']] ?? 'N/A'; ?></div>
                <div style="font-size: 19px; margin: 12px 0; border-bottom: 1px dashed #ccc; padding-bottom: 8px; text-align: left;"><strong>Fecha y Hora:</strong> <?php echo "{$t['fecha']} a las {$t['hora']} hrs"; ?></div>
                
                <a href="?seccion=inicio" class="btn-volver">Volver a la Página Principal</a>
            </div>

        <?php elseif ($seccion == 'medicos'): ?>
            <h2>Directorio de Médicos y Estado de Disponibilidad</h2>
            <p>Listado completo de los 30 especialistas con control de ausencias y vacaciones:</p>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Especialista</th>
                        <th>Especialidad</th>
                        <th>Ubicación</th>
                        <th>Estado Actual</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($medicos as $id => $info): ?>
                    <tr>
                        <td><strong><?php echo $id; ?></strong></td>
                        <td><?php echo $info[0]; ?></td>
                        <td><?php echo $info[1]; ?></td>
                        <td><?php echo $info[2]; ?></td>
                        <td>
                            <?php if($info[3] == 'Disponible'): ?>
                                <span class="badge-disponible">Disponible</span>
                            <?php else: ?>
                                <span class="badge-vacaciones">De Vacaciones</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php elseif ($seccion == 'tickets' && isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true): ?>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h2>Historial de Tickets y Comprobantes</h2>
                <a href="?seccion=tickets&logout=1" style="background-color: var(--rojo-uvm); color: white; padding: 8px 15px; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 15px;">Cerrar Sesión</a>
            </div>
            <p>Sesión activa para: <strong><?php echo $_SESSION['usuario_nombre']; ?> (ID: <?php echo $_SESSION['usuario_id']; ?>)</strong>.</p>
            
            <?php
            $tickets_a_mostrar = [];
            foreach ($_SESSION['tickets'] as $index => $t) {
                if ($_SESSION['usuario_id'] === 'ADM123' || $t['id_medico'] === $_SESSION['usuario_id']) {
                    $t['original_index'] = $index;
                    $tickets_a_mostrar[] = $t;
                }
            }
            ?>

            <?php if (empty($tickets_a_mostrar)): ?>
                <div style="background: white; padding: 30px; border-radius: 8px; text-align: center; border: 1px dashed var(--azul-marino); margin-top: 20px;">
                    <p style="font-size: 19px; color: #555;">No hay turnos registrados para este perfil en la sesión actual.</p>
                    <a href="?seccion=agendar" class="btn-card">Ir a Agendar Cita</a>
                </div>
            <?php else: ?>
                <?php if (isset($_GET['editar']) && is_numeric($_GET['editar'])): 
                    $edit_idx = $_GET['editar'];
                    $t_edit = $_SESSION['tickets'][$edit_idx] ?? null;
                    if ($t_edit):
                ?>
                    <div style="background: white; padding: 25px; border-radius: 8px; margin-bottom: 25px; border: 2px solid var(--azul-marino);">
                        <h3>Editar Cita: <?php echo $t_edit['id_turno']; ?> (Paciente: <?php echo htmlspecialchars($t_edit['nombre_paciente']); ?>)</h3>
                        <form action="" method="POST">
                            <input type="hidden" name="accion_cita" value="editar">
                            <input type="hidden" name="indice_ticket" value="<?php echo $edit_idx; ?>">
                            <div class="campo fila-flex">
                                <div><label>Nueva Fecha:</label><input type="date" name="fecha" value="<?php echo $t_edit['fecha']; ?>" required></div>
                                <div><label>Nueva Hora:</label>
                                    <select name="hora" required>
                                        <?php foreach($horas_disponibles as $h): ?>
                                            <option value="<?php echo $h; ?>" <?php echo ($h == $t_edit['hora']) ? 'selected' : ''; ?>><?php echo $h; ?> hrs</option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" style="background-color: var(--azul-marino); color: white; border: none; padding: 12px; font-weight: bold; border-radius: 5px; cursor: pointer;">Guardar Cambios y Notificar</button>
                            <a href="?seccion=tickets" style="margin-left: 15px; color: var(--rojo-uvm); text-decoration: none; font-weight: bold;">Cancelar</a>
                        </form>
                    </div>
                <?php endif; endif; ?>

                <table>
                    <thead>
                        <tr>
                            <th>ID Turno</th>
                            <th>Paciente</th>
                            <th>Médico Asignado</th>
                            <th>Servicio</th>
                            <th>Consultorio</th>
                            <th>Fecha y Hora</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tickets_a_mostrar as $t): ?>
                        <tr>
                            <td><strong><?php echo $t['id_turno']; ?></strong></td>
                            <td><?php echo htmlspecialchars($t['nombre_paciente']); ?></td>
                            <td><?php echo $medicos[$t['id_medico']][0] ?? $t['id_medico']; ?></td>
                            <td><?php echo $servicios[$t['id_servicio']] ?? $t['id_servicio']; ?></td>
                            <td><?php echo $consultorios[$t['id_consultorio']] ?? $t['id_consultorio']; ?></td>
                            <td><?php echo "{$t['fecha']} a las {$t['hora']} hrs"; ?></td>
                            <td>
                                <a href="?seccion=tickets&editar=<?php echo $t['original_index']; ?>" style="background-color: var(--azul-marino); color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 14px; font-weight: bold;">Editar Cita</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

        <?php endif; ?>

    </div>

</body>
</html>