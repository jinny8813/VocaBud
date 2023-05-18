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

                <div class="card mb-3 d-none" id="cardCreateDict">
                    <div class="card-body">
                        <div class="fs-5 mb-2">3. 選擇解釋</div>
                        <div id="radioGroup"></div>
                    </div>
                </div>

                <div class="card mb-3 d-none" id="cardCreate">
                    <div class="card-body">
                        <div class="fs-5 mb-2 d-none" id="self">2. 自填單字釋義</div>
                        <div class="fs-5 mb-2 d-none" id="dict">4. 修改或直接送出</div>
                        <form id="cardCreateForm">
                                <div class="form-group row mb-3">
                                    <div class="col-3">
                                        <label for="title" class="form-label">卡片英文</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" name="title" id="title" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <div class="col-3">
                                        <label for="part_of_speech" class="form-label">卡片詞性</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" name="part_of_speech" id="part_of_speech" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <div class="col-3">
                                        <label for="pronunciation" class="form-label">卡片發音</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" name="pronunciation" id="pronunciation" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <div class="col-3">
                                        <label for="content" class="form-label">卡片短譯</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" name="content" id="content" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <div class="col-3">
                                        <label for="e_sentence" class="form-label">英/造句</label>
                                    </div>
                                    <div class="col-9">
                                        <textarea  name="e_sentence" id="e_sentence" class="form-control" rows="4"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <div class="col-3">
                                        <label for="c_sentence" class="form-label">中/補充</label>
                                    </div>
                                    <div class="col-9">
                                        <textarea  name="c_sentence" id="c_sentence" class="form-control" rows="4"></textarea>
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
    let cardCreate = document.getElementById("cardCreate");
    let self = document.getElementById("self");
    let dict = document.getElementById("dict");

    document.getElementById("cardscreate1").addEventListener("click",(e) => {
        cardCreate.classList.add('d-none');
        cardCreateDict.classList.add('d-none');
        self.classList.add('d-none');
        dict.classList.remove('d-none');
        cardSearch.classList.remove('d-none');
    })
    document.getElementById("cardscreate2").addEventListener("click",(e) => {
        cardSearch.classList.add('d-none');
        cardCreateDict.classList.add('d-none');
        dict.classList.add('d-none');
        self.classList.remove('d-none');
        cardCreate.classList.remove('d-none');
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
                innerMsg(response.data);
                cardCreateDict.classList.remove('d-none');
                cardCreate.classList.remove('d-none');
                dict.classList.remove('d-none');
            }).catch((e) => {
                console.log(e.response.data);
            })
        },
    }

    function innerMsg(data){
        let radioGroup = document.getElementById("radioGroup");
        radioGroup.innerHTML = "";
        for(let i = 0; i < Object.keys(data).length; i++){
            let mytext = `<div class="form-check">
                            <input type="radio" class="form-check-input" name="theWord" id="${i}" value=${data[i]}>
                            (${i+1}). <strong>${data[i][0]}</strong> <small>(${data[i][1]}.)</small></br>
                            /${data[i][2]}/</br>
                            ${data[i][3]}</br>
                            ${data[i][4]}</br></div>`;
            $(radioGroup).append(mytext);

            let wordid=document.getElementById(i);
            wordid.addEventListener('click', function () {
                document.getElementById("title").value = data[i][0];
                document.getElementById("part_of_speech").value = data[i][1];
                document.getElementById("pronunciation").value = data[i][2];
                document.getElementById("e_sentence").value = data[i][3];
                document.getElementById("c_sentence").value = data[i][4];
            });
        }
    }
</script>
<?= $this->endSection()?>