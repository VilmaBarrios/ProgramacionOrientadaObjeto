<?php
// 1. Categorías en un arreglo (como exige la guía)
$categorias = [
    'principales' => 'Personajes Principales',
    'villanos'    => 'Villanos',
    'amigos'      => 'Amigos de Shrek',
    'secundarios' => 'Personajes Secundarios'
];

// 2. Arreglo de todos los personajes
$personajes = [
    [
        'nombre'      => 'Shrek',
        'descripcion' => 'Un ogro verde que ama la tranquilidad de su pantano.',
        'categoria'   => 'principales',
        'imagen'      => 'shrek.png'
    ],
    [
        'nombre'      => 'Fiona',
        'descripcion' => 'Princesa independiente con un secreto bajo la luz de la luna.',
        'categoria'   => 'principales',
        'imagen'      => 'fiona.png'
    ],
    [
        'nombre'      => 'Burro',
        'descripcion' => 'Un parlanchín y leal amigo inseparable de Shrek.',
        'categoria'   => 'amigos',
        'imagen'      => 'burro.png'
    ],
    [
        'nombre'      => 'Gato con Botas',
        'descripcion' => 'Fiero espadachín experto en miradas tiernas.',
        'categoria'   => 'amigos',
        'imagen'      => 'gato.png'
    ],
    [
        'nombre'      => 'Lord Farquaad',
        'descripcion' => 'Soberano de Duloc obsesionado con la perfección.',
        'categoria'   => 'villanos',
        'imagen'      => 'farquaad.png'
    ],
    [
        'nombre'      => 'Hada Madrina',
        'descripcion' => 'Empresaria mágica que busca imponer finales felices.',
        'categoria'   => 'villanos',
        'imagen'      => 'hada.png'
    ],
    [
        'nombre'      => 'Jengibre',
        'descripcion' => 'Galleta valiente que no cede ante la tortura de leche.',
        'categoria'   => 'secundarios',
        'imagen'      => 'jengi.png'
    ]
];

// 3. Filtrado por parámetro GET
$cat_seleccionada = $_GET['cat'] ?? 'todas';

$lista_filtrada = $personajes;
if ($cat_seleccionada !== 'todas' && array_key_exists($cat_seleccionada, $categorias)) {
    $lista_filtrada = array_filter($personajes, function($p) use ($cat_seleccionada) {
        return $p['categoria'] === $cat_seleccionada;
    });
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Personajes de Shrek</title>
    <style>
        body { font-family: sans-serif; background: #f0f4f8; padding: 20px; }
        .nav { margin-bottom: 20px; }
        .nav a { text-decoration: none; padding: 8px 14px; background: #2b7a78; color: white; border-radius: 4px; margin-right: 5px; }
        .nav a.active { background: #17252a; }
        .contenedor { display: flex; flex-wrap: wrap; gap: 20px; }
        .card { background: white; border-radius: 8px; width: 200px; padding: 15px; border: 1px solid #ccc; text-align: center; }
        .card img { max-width: 100%; height: 150px; object-fit: contain; }
        .badge { background: #3aaf9f; color: white; padding: 3px 8px; border-radius: 12px; font-size: 12px; }
    </style>
</head>
<body>

    <h1>Personajes de Shrek</h1>

    <!-- Menú Dinámico -->
    <div class="nav">
        <a href="?" class="<?= $cat_seleccionada == 'todas' ? 'active' : '' ?>">Todos</a>
        <?php foreach ($categorias as $clave => $nombre): ?>
            <a href="?cat=<?= $clave ?>" class="<?= $cat_seleccionada == $clave ? 'active' : '' ?>">
                <?= $nombre ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Lista Filtrada -->
    <div class="contenedor">
        <?php foreach ($lista_filtrada as $p): ?>
            <div class="card">
                <img src="<?= htmlspecialchars($p['imagen']) ?>" alt="<?= htmlspecialchars($p['nombre']) ?>">
                <h3><?= htmlspecialchars($p['nombre']) ?></h3>
                <p><?= htmlspecialchars($p['descripcion']) ?></p>
                <span class="badge"><?= htmlspecialchars($categorias[$p['categoria']]) ?></span>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>