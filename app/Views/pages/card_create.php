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
                        <div>
                            <a href="<?= base_url('/books') ?>" class="btn p-2"><i class="fa-fw fa-solid fa-hand-point-left"></i></a>
                        </div>
                        <div class="card w-75">
                            <div class="card-body">
                                <div class="text-center fs-3">創建自己的卡片!</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container py-5">
        <div class="row justify-content-center my-3">
            <div class="col-md-8 my-3">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="text-center fs-3 mb-3">創建卡片</div>
                        <div class="fs-5 mb-2">1. 選擇創建字卡的模式</div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="cardscreate" id="cardscreate1">
                            <label class="form-check-label" for="cardscreate1">
                                英英字典創建字卡
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="cardscreate" id="cardscreate2">
                            <label class="form-check-label" for="cardscreate2">
                                手動創建字卡
                            </label>
                        </div>
                    </div>
                </div>

                <div class="card mb-3 d-none" id="cardSearch">
                    <div class="card-body">
                        <div class="fs-5 mb-2">2. 搜尋單字</div>
                        <form id="cardSearchForm">
                            <div class="form-group row mb-3">
                                <div class="col-3">
                                    <label for="word" class="form-label">單字</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" name="word" class="form-control" placeholder="請輸入單字" required>
                                </div>
                            </div>
                            <div class="form-group d-flex justify-content-center">
                                <button type="submit" name="submit" class="btn">送出</button>
                            </div>
                        </form>
                    </div>
                </div>


                <div id="cardCreateDict" class="d-none">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="fs-5 mb-2">3. 選擇解釋</div>
                            <div id="radioGroup"></div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="fs-5 mb-2">4. 修改或直接送出</div>
                            <form id="cardCreateDictForm">
                                <div class="form-group row mb-3">
                                    <div class="col-3">
                                        <label for="title" class="form-label">卡片英文</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" name="title" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <div class="col-3">
                                        <label for="part_of_speech" class="form-label">卡片音標</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" name="part_of_speech" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <div class="col-3">
                                        <label for="pronunciation" class="form-label">卡片短譯</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" name="pronunciation" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <div class="col-3">
                                        <label for="content" class="form-label">英譯/造句</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" name="content" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <div class="col-3">
                                        <label for="e_sentence" class="form-label">中譯/補充</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" name="e_sentence" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <div class="col-3">
                                        <label for="c_sentence" class="form-label">卡片詞性</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" name="c_sentence" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group d-flex justify-content-center">
                                    <button type="submit" name="submit" class="btn">送出</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                    <div class="card mb-3 d-none" id="cardCreateSelf">
                        <div class="card-body">
                            <div class="fs-5 mb-2">2. 自填單字釋義</div>
                            <form id="cardCreateSelfForm">
                                <div class="form-group row mb-3">
                                    <div class="col-3">
                                        <label for="title" class="form-label">卡片英文</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" name="title" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <div class="col-3">
                                        <label for="part_of_speech" class="form-label">卡片音標</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" name="part_of_speech" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <div class="col-3">
                                        <label for="pronunciation" class="form-label">卡片短譯</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" name="pronunciation" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <div class="col-3">
                                        <label for="content" class="form-label">英譯/造句</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" name="content" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <div class="col-3">
                                        <label for="e_sentence" class="form-label">中譯/補充</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" name="e_sentence" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <div class="col-3">
                                        <label for="c_sentence" class="form-label">卡片詞性</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" name="c_sentence" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group d-flex justify-content-center">
                                    <button type="submit" name="submit" class="btn">送出</button>
                                </div>
                            </form>
                        </div>
                    </div>

            </div>
        </div>
    </div>
</section>
<script>
    let cardSearch = document.getElementById("cardSearch");
    let cardCreateDict = document.getElementById("cardCreateDict");
    let cardCreateSelf = document.getElementById("cardCreateSelf");

    document.getElementById("cardscreate1").addEventListener("click",(e) => {
        cardCreateSelf.classList.add('d-none');
        cardCreateDict.classList.add('d-none');
        cardSearch.classList.remove('d-none');
    })
    document.getElementById("cardscreate2").addEventListener("click",(e) => {
        cardSearch.classList.add('d-none');
        cardCreateDict.classList.add('d-none');
        cardCreateSelf.classList.remove('d-none');
    })

    document.getElementById("cardSearchForm").addEventListener("submit",(e) => {
        e.preventDefault();
        let formdata= new FormData(cardSearchForm);
        myLib1.POST("<?= base_url('/cards/search') ?>",formdata);
    })

    let myLib1 = {
        POST: (url,formdata) => {
            axios.post(url,formdata)
            .then((response) => {
                console.log(response);
                cardCreateDict.classList.remove('d-none');
            }).catch((e) => {
                console.log(e.response.data);
            })
        },
    }
</script>
<?= $this->endSection()?>