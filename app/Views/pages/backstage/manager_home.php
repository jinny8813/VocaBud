<?= $this->extend("layout/backstage/template")?>
<?= $this->section('backstage_content')?>
<section class="min-vh-100 bg_light">
    <div class="w-100">
        <img class="img-fluid" src="<?= base_url('../../public/assets/images/banner.jpg') ?>" alt="">
    </div>
    <div class="container position-relative">
        <div class="row justify-content-center">
            <div class="col-md-8 col-10 position-absolute top-100 start-50 translate-middle">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center fs-3"><?= esc($nickname)?>的管理主頁</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-6" style="background-color:#2c4c01">
                <div class="text-center fs-5 py-5"><a class="a_white" href="<?= base_url('/cards') ?>">後台統計</a></div>
            </div>
            <div class="col-md-3 col-6" style="background-color:#628100">
                <div class="text-center fs-5 py-5"><a class="a_white" href="#">後台設定</a></div>
            </div>
            <div class="col-md-3 col-12" style="background-color:#dfc403">
                <div class="text-center fs-5 py-5"><a class="a_white" href="<?= base_url('/quizlets') ?>">活動管理</a></div>
            </div>
            <div class="col-md-4 col-6" style="background-color:#c9d1d4">
                <div class="text-center fs-5 py-5"><a class="a_white" href="<?= base_url('/statistics') ?>">意見回饋</a></div>
            </div>
            <div class="col-md-8 col-6" style="background-color:#505c58">
                <div class="text-center fs-5 py-5"><a class="a_white" href="<?= base_url('/managerinfo')?>">人員管理</a></div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection()?>