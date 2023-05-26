<?= $this->extend("layout/template")?>
<?= $this->section('content')?>
<section class="min-vh-100 bg_light">
    <div class="container-fluid bg_green bg_green_title">
        <div class="row justify-content-center">
            <div class="col-md-8 row justify-content-center align-items-center">
                <div class="col-1 p-0">
                    <a href="<?= base_url('/quizlets') ?>" class="btn btn_low_key p-0"><i class="fa-fw fa-regular fa-hand-point-left"></i></a>
                </div>
                <div class="col-10 pt-3 pb-4">
                    <div class="fs-3 text-center">建立測驗吧</div>
                </div>
                <div class="col-1">
                </div>
            </div>
        </div>
    </div>

    <div class="container pb-5">
        <div class="row justify-content-center my-3">
            <div class="col-md-8 my-3">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center fs-3 mb-3">創建測驗</div>
                        <form id="quizCreateForm">
                            <div class="form-group row mb-3">
                                <div class="col-3">
                                    <label for="title" class="form-label">選擇書本</label>
                                </div>
                                <div class="col-9">
                                    <?php foreach($books as $row):?>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="book_group" value="<?= $row['book_id']?>"><?= $row['book_title']?></div>
                                    <?php endforeach;?>
                                    <span id="bookError" class="text-danger d-none" >請選擇至少一個書本</span>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <div class="col-3">
                                    <label for="select_state" class="form-label">字卡狀態</label>
                                </div>
                                <div class="col-9">
                                    <select name="select_state"id="select_state" class="form-select">
                                        <option value="未測驗">未測驗</option>
                                        <option value="已測驗">已測驗</option>
                                        <option value="差">差</option>
                                        <option value="弱">弱</option>
                                        <option value="中">中</option>
                                        <option value="可">可</option>
                                        <option value="佳">佳</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <div class="col-3">
                                    <label for="select_old" class="form-label">未複習逾</label>
                                </div>
                                <div class="col-9">
                                    <select name="select_old"id="select_old" class="form-select">
                                        <option value="0">不限</option>
                                        <option value="3">3天</option>
                                        <option value="7">7天</option>
                                        <option value="10">10天</option>
                                        <option value="15">15天</option>
                                        <option value="30">30天</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <div class="col-3">
                                    <label for="select_wrong" class="form-label">近一月逾</label>
                                </div>
                                <div class="col-9">
                                    <select name="select_wrong"id="select_wrong" class="form-select">
                                        <option value="0">不限</option>
                                        <option value="5">5錯誤</option>
                                        <option value="10">10錯誤</option>
                                        <option value="15">15錯誤</option>
                                        <option value="30">30錯誤</option>
                                        <option value="50">50錯誤</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <div class="col-3">
                                    <label for="select_amount" class="form-label">測驗數量</label>
                                </div>
                                <div class="col-9">
                                    <select name="select_amount"id="select_amount" class="form-select">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <div class="col-3">
                                    <label for="" class="form-label">隨機補足</label>
                                </div>
                                <div class="col-9">
                                    <input class="form-check-input" type="radio" name="add_random" id="add_random1" checked value="no">
                                    <label class="form-check-label" for="add_random1">不補足，有多少測驗多少</label>
                                    <br>
                                    <input class="form-check-input" type="radio" name="add_random" id="add_random2" disabled value="random">
                                    <label class="form-check-label" for="add_random2">隨機補足至選擇之測驗數量</label>
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
    let quizCreateForm = document.getElementById("quizCreateForm");

    quizCreateForm.addEventListener("submit",(e) => {
        let select_book = new Array();
        $.each($("input[name='book_group']:checked"), function() {
            select_book.push(parseInt($(this).val()));
        });
        if(select_book.length==0){
            document.getElementById('bookError').classList.remove('d-none');
        }else{
            document.getElementById('bookError').classList.add('d-none');
        }
        e.preventDefault();

        let formdata= new FormData(quizCreateForm);
        formdata.append("select_book", select_book.toString());
        myLib1.POST("<?= base_url('/quizlets/generate') ?>",formdata);
    })

    let myLib1 = {
        POST: (url,formdata) => {
            axios.post(url,formdata)
            .then((response) => {
                window.location.href = `<?= base_url('/quizlets/flashcard')?>`;
            }).catch((e) => {
                console.log(e);
            })
        },
    }
</script>
<?= $this->endSection()?>