<header class="sticky-top">
  <nav class="navbar navbar-expand-lg p-0">
      <div class="img_h">
        <a class="navbar-brand p-3" href="<?= base_url('/home')?>" style="color:white"
          ><img src="<?= base_url('../../public/assets/images/icon.png') ?>" class="h-100 px-2" />LetsgoVoc
        </a>
      </div>

      <button class="navbar-toggler p-3" style="border: none;" data-bs-toggle="collapse" data-bs-target="#navbar">
        <i class="fas fa-bars" style="color:white"></i>
      </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbar">
      <ul class="navbar-nav">
        <li class="nav-item ">
          <a class="nav-link p-3" href="<?= base_url('/cards') ?>">我的字卡</a>
        </li>
        <li class="nav-item ">
          <a class="nav-link p-3" href="#">分享廣場</a>
        </li>
        <li class="nav-item ">
          <a class="nav-link p-3" href="<?= base_url('/quizlets') ?>">測驗大廳</a>
        </li>
        <li class="nav-item ">
          <a class="nav-link p-3" href="<?= base_url('/statistics') ?>">統計收集</a>
        </li>
        <li class="nav-item ">
          <a class="nav-link p-3" href="<?= base_url('/personal')?>">個人設定</a>
        </li>
        <li class="nav-item ">
          <a class="nav-link p-3" href="<?= base_url("/logout") ?>">登出</a>
        </li>
      </ul>
    </div>
  </nav>
</header>