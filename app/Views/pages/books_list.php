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
                    <div class="position-absolute top-100 start-50 translate-middle d-flex justify-content-around align-items-center w-100">
                        <div class="card w-75">
                            <div class="card-body">
                                <div class="text-center fs-3">書本列表</div>
                            </div>
                        </div>
                        <div>
                            <a href="#" class="btn p-2" data-bs-toggle="modal" data-bs-target="#infoModal"><i class="fa-fw fa-solid fa-info"></i></a>
                        </div>
                        <div>
                            <a href="<?= base_url('/books/new') ?>" class="btn p-2"><i class="fa-fw fa-solid fa-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="infoModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">使用說明</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>LetsgoVoc由書本長出字卡，也可以說是由字卡堆砌成書本。可以把書本視為一種分類~</p>
                        <p>1. 書本的新增、列表、修改、刪除</p>
                        <p>2. 字卡的新增、列表、修改、刪除</p>
                        <p>3. 列表、單字可進行輪播翻卡練習</p>
                        <p>4. 如需跨書本練習，可以至"所有單字"進行排序篩選</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container py-5">
        <div class="row justify-content-center my-3">
            <div class="col-md-10">
                <?php foreach($books as $row):?>
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-3 d-flex align-items-center justify-content-center bg_dark_blue rounded-start">
                            <div class="text-center">99%</div>
                        </div>
                        <div class="col-9 card-body">
                            <div class="fs-5">
                                <a href="<?= base_url('books/'.$row['book_id'])?>" class="a_black stretched-link"><?= $row['book_title']?></a>
                            </div>
                            <p class="ellipsis"><?= $row['book_description']?></p>
                            <div><i class="fa-fw fa-solid fa-swatchbook"></i>999</div>
                        </div>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection()?>