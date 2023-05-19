<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="../index.php">
            <img src="./assets/img/logo-ct.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold text-white">book書易</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white" href="../index.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-house"></i>
                    </div>
                    <span class="nav-link-text ms-1 ">首頁</span>
                </a>
            </li>
            <li class="nav-item">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            <a class="nav-link text-white " href="#">
                                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                <span class="nav-link-text ms-1 ">會員管理</span>
                            </a>
                        </button>
                    </h2>
                </div>
            </li>
            <li class="nav-item">
                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <a class="nav-link text-white " href="../member/ticket-admin.php">
                            <div class="text-white text-center me-2 px-4 d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-pencil"></i>
                                <span class="nav-link-text ms-3">客服</span>
                            </div>
                        </a>
                    </div>
                </div>
            </li>
            <!--需要用一個以上的手風琴細項從這裡拷貝-->
            <li class="nav-item">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <a class="nav-link text-white " href="../leo/order.php">
                                <div class="text-white text-center me-2  d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-rectangle-list"></i>
                                </div>
                                <span class="nav-link-text ms-1 ">商城/訂單管理</span>
                            </a>
                        </button>
                    </h2>
                </div>
            </li>
            <li class="nav-item">
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <a class="nav-link text-white " href="../leo/market.php">
                            <div class="text-white text-center me-2 px-4 d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-pencil"></i>
                                <span class="nav-link-text ms-2">商城</span>
                            </div>
                        </a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <a class="nav-link text-white " href="../leo/order.php">
                            <div class="text-white text-center me-2 px-4 d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-pencil"></i>
                                <span class="nav-link-text ms-2">訂單管理</span>
                            </div>
                        </a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <a class="nav-link text-white " href="../leo/coupon.php">
                        <div class="text-white text-center me-2 px-4 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-pencil"></i>
                            <span class="nav-link-text ms-2">促銷與折價券</span>
                        </div>
                    </a>
                </div>
            </li>

            <li class="nav-item">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            <a class="nav-link text-white " href="../used/used_list_1.php">
                                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-book-open"></i>
                                </div>
                                <span class="nav-link-text ms-1 ">二手書管理</span>
                            </a>
                    </h2>
                </div>
            </li>
            <li class="nav-item">
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <a class="nav-link text-white " href="../used/used_list_1.php">
                            <div class="text-gray text-center me-2 px-4 d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-pencil"></i>
                                <span class="nav-link-text ms-3">二手書清單</span>
                            </div>
                        </a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <a class="nav-link text-white " href="../used/used_bs_list.php">
                            <div class="text-gray text-center me-2 px-4 d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-pencil"></i>
                                <span class="nav-link-text ms-3">書況管理</span>
                            </div>
                        </a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            <a class="nav-link text-white " href="./blog./blog.html">
                                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-rectangle-list"></i>
                                </div>
                                <span class="nav-link-text ms-1 ">部落格書評管理</span>
                            </a>
                        </button>
                    </h2>
                </div>
            </li>
            <li class="nav-item">
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <a class="nav-link text-white " href="../book-review/book-review.php">
                            <div class="text-white text-center me-2 px-4 d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-pencil"></i>
                                <span class="nav-link-text ms-3">書評管理</span>
                            </div>
                        </a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                    <a class="nav-link text-white " href="../blog/blog-filter.php">
                        <div class="text-white text-center me-2 px-4 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-pencil"></i>
                            <span class="nav-link-text ms-3">部落格管理</span>
                        </div>
                    </a>
                </div>
            </li>
            <li class="nav-item">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFive">
                        <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            <a class="nav-link text-white " href="#">
                                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-comments opacity-10"></i>
                                </div>
                                <span class="nav-link-text ms-1">論壇</span>
                            </a>
                    </h2>
                </div>
            </li>
            <li class="nav-item">
                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <a class="nav-link text-white " href="./f-index.php">
                            <div class="text-white text-center me-2 px-4 d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-pencil"></i>
                                <span class="nav-link-text ms-3">論壇管理</span>
                            </div>
                        </a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <a class="nav-link text-white " href="./category.php">
                            <div class="text-white text-center me-2 px-4 d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-pencil"></i>
                                <span class="nav-link-text ms-3">類別管理</span>
                            </div>
                        </a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                    <a class="nav-link text-white " href="./post.php">
                        <div class="text-white text-center me-2 px-4 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-pencil"></i>
                            <span class="nav-link-text ms-3">貼文管理</span>
                        </div>
                    </a>
                </div>
            </li>
            <li class="nav-item">
                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                    <a class="nav-link text-white " href="./comment.php">
                        <div class="text-white text-center me-2 px-4 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-pencil"></i>
                            <span class="nav-link-text ms-3">留言管理</span>
                        </div>
                    </a>
                </div>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2  text-lg text-white font-weight-bolder opacity-8">管理操作</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white " href="./login/login.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">login</i>
                    </div>
                    <span class="nav-link-text ms-1">登入</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white " href="./pages/sign-up.html">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">assignment</i>
                    </div>
                    <span class="nav-link-text ms-1">登出</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
<main class="main-content position-relative max-height-vh-100 h-100 py-3 border-radius-lg ">