<?= $this->extend("layout/template")?>
<?= $this->section('content')?>
<section class="min-vh-100 bg_light">
    <div class="container-fluid bg_green">
        <div class="row justify-content-center">
            <div class="col-md-8 row justify-content-around align-items-center">
                <div class="col-1 p-0">
                    <a href="#" class="btn btn_low_key p-0"><i class="fa-fw fa-regular fa-hand-point-left"></i></a>
                </div>
                <div class="col-1 p-0">
                    <a href="#" class="btn btn_low_key p-0"><i class="fa-fw fa-solid fa-info"></i></a>
                </div>
                <div class="col-8 p-3">
                    <div class="fs-3 text-center">BooksCollection</div>
                </div>
                <div class="col-2">
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 col-10">
                <form>
                    <div class="row align-items-center mb-3">
                        <div class="col-11 mb-3">
                            <input type="text" class="form-control" id="" placeholder="search...">
                        </div>
                        <div class="col-1 mb-3 p-0">
                            <button type="submit" class="btn btn_low_key p-0"><i class="fa-fw fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="position-sticky top-0 z-3">
        <div class="position-relative">
            <div class="position-absolute top-0 end-0 pt-5 mt-3">
                <button class="btn btn_the_biggest fs-4 p-2" id="bigBtn"><i class="fa-fw fa-solid fa-toolbox"></i></button>
                <div id="groupBtn" class="d-none">
                    <div class="d-flex">
                        <a href="#" class="btn btn_biggest_down p-2"><i class="fa-fw fa-solid fa-toolbox"></i></a>
                    </div>
                    <div class="d-flex">
                        <a href="#" class="btn btn_biggest_down p-2"><i class="fa-fw fa-solid fa-toolbox"></i></a>
                    </div>
                    <div class="d-flex">
                        <a href="#" class="btn btn_biggest_down p-2"><i class="fa-fw fa-solid fa-toolbox"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container py-3">
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
<script>
    let groupBtn = document.getElementById("groupBtn");
    document.getElementById("bigBtn").addEventListener("click",(e) => {
        groupBtn.classList.toggle("d-none");
    })
</script>
<?= $this->endSection()?>