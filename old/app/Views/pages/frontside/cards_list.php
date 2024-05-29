<?= $this->extend("layout/frontside/template")?>
<?= $this->section('frontside_content')?>
<section class="min-vh-100 bg_light">
    <div class="container-fluid bg_green">
        <div class="row justify-content-center">
            <div class="col-md-8 row justify-content-center align-items-center">
                <div class="col-1 p-0">
                    <a href="<?= base_url('/home')?>" class="btn btn_low_key p-0"><i class="fa-fw fa-regular fa-hand-point-left"></i></a>
                </div>
                <div class="col-1 p-0">
                    <a href="#" class="btn btn_low_key p-0"><i class="fa-fw fa-solid fa-info"></i></a>
                </div>
                <div class="col-8 p-3">
                    <div class="fs-3 text-center">所有字卡</div>
                </div>
                <div class="col-2">
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 col-10 pb-4">
                <div>-</div>
            </div>
        </div>
    </div>

    <div class="container pt-3">
        <div class="row justify-content-center">
            <div class="col-8">
                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link show" id="pills-all-tab" data-bs-toggle="pill" data-bs-target="#pills-all" type="button" role="tab" aria-controls="pills-all" aria-selected="true">字卡</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-tags-tab" data-bs-toggle="pill" data-bs-target="#pills-tags" type="button" role="tab" aria-controls="pills-tags" aria-selected="false">tags</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-notag-tab" data-bs-toggle="pill" data-bs-target="#pills-notag" type="button" role="tab" aria-controls="pills-notag" aria-selected="false">未分類</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="position-sticky top-0 z-3">
        <div class="position-relative">
            <div class="position-absolute top-0 end-0 mt-3 pt-5">
                <button class="btn btn_the_biggest fs-4 p-2" id="bigBtn"><i class="fa-fw fa-solid fa-toolbox"></i></button>
                <div id="groupBtn" class="d-none">
                    <div class="d-flex">
                        <a href="<?= base_url('cards/new')?>" class="btn btn_biggest_down p-2"><i class="fa-fw fa-solid fa-plus"></i></a>
                    </div>
                    <div class="d-flex">
                        <a href="#" class="btn btn_biggest_down p-2"><i class="fa-fw fa-solid fa-eye"></i></a>
                    </div>
                    <div class="d-flex">
                        <a href="#" class="btn btn_biggest_down p-2"><i class="fa-fw fa-solid fa-play"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container pb-3">
        <div class="row justify-content-center my-3">
            <div class="col-md-10">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab">
                        <?php foreach($cards as $row):?>
                            <div class="card mb-3">
                                <div class="row g-0">
                                    <div class="col-2 d-flex align-items-center justify-content-center rounded-start cardBgColor">
                                        <div class="text-center cardState" style="color: white;"><?= $row['grade']?></div>
                                    </div>
                                    <div class="col-10 card-body">
                                        <div class="fs-5">
                                            <strong><a href="<?= base_url('cards/'.$row['uuid'])?>" class="a_black stretched-link"><?= $row['title']?></a></strong> <small>(<?= $row['part_of_speech']?>.)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;?>
                    </div>

                    <div class="tab-pane fade" id="pills-tags" role="tabpanel" aria-labelledby="pills-tags-tab">
                        <?php foreach($tags as $row):?>
                        <div class="card mb-3">
                            <div class="row g-0">
                                <div class="col-3 d-flex align-items-center justify-content-center bg_dark_blue rounded-start">
                                    <div class="text-center"></div>
                                </div>
                                <div class="col-9 card-body">
                                    <div class="fs-5">
                                        <strong><a href="#" class="a_black stretched-link"><?= $row['tagname']?></a></strong>
                                    </div>
                                    <p class="ellipsis"><?= $row['description']?></p>
                                    <div><i class="fa-fw fa-solid fa-swatchbook"></i> <?= $row['count']?></div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach;?>
                    </div>

                    <div class="tab-pane fade" id="pills-notag" role="tabpanel" aria-labelledby="pills-notag-tab">
                        <?php foreach($notagcards as $row):?>
                            <div class="card mb-3">
                                <div class="row g-0">
                                    <div class="col-2 d-flex align-items-center justify-content-center rounded-start cardBgColor">
                                        <div class="text-center cardState" style="color: white;"><?= $row['grade']?></div>
                                    </div>
                                    <div class="col-10 card-body">
                                        <div class="fs-5">
                                            <strong><a href="<?= base_url('cards/'.$row['uuid'])?>" class="a_black stretched-link"><?= $row['title']?></a></strong> <small>(<?= $row['part_of_speech']?>.)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<script>
    let groupBtn = document.getElementById("groupBtn");
    document.getElementById("bigBtn").addEventListener("click",(e) => {
        groupBtn.classList.toggle("d-none");
    })

    let cardBgColor = document.querySelectorAll(".cardBgColor");
    let cardState = document.querySelectorAll(".cardState");

    cardState.forEach((item, index) => {
        let grade = item.textContent;
        switch(grade){
            case "A":
                cardBgColor[index].style.backgroundColor = "#E6E164";
                break;
            case "B":
                cardBgColor[index].style.backgroundColor = "#95CD7B";
                break;
            case "C":
                cardBgColor[index].style.backgroundColor = "#5EC7B4";
                break;
            case "D":
                cardBgColor[index].style.backgroundColor = "#63AFD9";
                break;
            case "F":
                cardBgColor[index].style.backgroundColor = "#7781DE";
                break;
            case "New":
                cardBgColor[index].style.backgroundColor = "#B686DB";
                break;
        }
    });
</script>
<?= $this->endSection()?>