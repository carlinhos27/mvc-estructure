<?php
$menuItems = [
  [
    'label' => 'Home',
    'url' => '/',
    'submenu' => []
  ],
  [
    'label' => 'Clientes',
    'url' => '/clientes',
    'submenu' => [
      ['label' => 'Nuevo cliente', 'url' => '/clientes/crear']
    ]
  ],
];
$currentUrl = $_SERVER['REQUEST_URI']; // Obtiene la URL actual
?>

<div class="navbar bg-base-100">
  <div class="navbar-start">
    <div class="dropdown">
      <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
        </svg>
      </div>
      <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
        <?php foreach ($menuItems as $item): ?>
          <li>
            <a href="<?= $item['url'] ?>" class="<?= ($currentUrl === $item['url']) ? 'underline underline-offset-4' : '' ?>">
              <?= $item['label'] ?>
            </a>
            <?php if (!empty($item['submenu'])): ?>
              <ul class="p-2">
                <?php foreach ($item['submenu'] as $subitem): ?>
                  <li>
                    <a href="<?= $subitem['url'] ?>" class="<?= ($currentUrl === $subitem['url']) ? 'underline underline-offset-4' : '' ?>">
                      <?= $subitem['label'] ?>
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <a class="btn btn-ghost text-xl" href="/">CRM</a>
  </div>

  <div class="navbar-center hidden lg:flex">
    <ul class="menu menu-horizontal px-1">
      <?php foreach ($menuItems as $item): ?>
        <li>
          <?php if (!empty($item['submenu'])): ?>
            <details>
              <summary>
                <a href="<?= $item['url'] ?>" class="<?= ($currentUrl === $item['url']) ? 'underline underline-offset-4' : '' ?>">
                  <?= $item['label'] ?>
                </a>
              </summary>
              <ul class="p-2">
                <?php foreach ($item['submenu'] as $subitem): ?>
                  <li>
                    <a href="<?= $subitem['url'] ?>" class="<?= ($currentUrl === $subitem['url']) ? 'underline underline-offset-4' : '' ?>">
                      <?= $subitem['label'] ?>
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
            </details>
          <?php else: ?>
            <a href="<?= $item['url'] ?>" class="<?= ($currentUrl === $item['url']) ? 'underline underline-offset-4' : '' ?>">
              <?= $item['label'] ?>
            </a>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
  <div class="navbar-end">
    <div class="flex items-center gap-2 cursor-pointer px-4 py-2 rounded-lg hover:bg-gray-200">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1118.88 17.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
      </svg>
      <span>User</span>
    </div>
  </div>
</div>