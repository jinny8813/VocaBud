<?= $this->extend("layout/template")?>
<?= $this->section('content')?>
<section class="min-vh-100 bg_light">
    <div class="w-100">
        <img class="img-fluid" src="<?= base_url('../../public/assets/images/banner.jpg') ?>" alt="">
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="position-relative">
                    <div class="position-absolute top-100 start-50 translate-middle d-flex justify-content-between align-items-center w-100">
                        <div class="card w-75">
                            <div class="card-body">
                                <div class="text-center fs-3">書本列表</div>
                            </div>
                        </div>
                        <div>
                            <a href="#" class="btn p-2"><i class="fa-fw fa-solid fa-arrow-up"></i></a>
                        </div>
                        <div>
                            <a href="#" class="btn p-2"><i class="fa-fw fa-solid fa-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container py-5">
        <div class="row justify-content-center my-3">
            <div class="col-md-10">

                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-3 d-flex align-items-center justify-content-center bg_dark_blue rounded-start">
                            <p class="text-center">000</p>
                        </div>
                        <div class="col-9 card-body">
                            <div class="fs-5">
                                <a href="" class="a_black stretched-link">的個人主頁的個人主頁</a>
                            </div>
                            <p class="ellipsis">的個人主頁的個人主頁的個人主頁的個人主頁的個人主頁的個人主頁</p>
                            <div><i class="fa-fw fa-solid fa-swatchbook"></i>123</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<?= $this->endSection()?>