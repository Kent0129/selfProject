
<nav class="navbar navbar-expand-sm bg-light navbar-light justify-content-end">
  <a class="navbar-brand mx-2 btn btn-outline-secondary" href="../Job/index.php">TOP PAGE</a>
  <div class="nav-right">
        <button class="navbar-toggler mx-2" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse flex-grow-0" id="navbarSupportedContent">
            <ul class="navbar-nav text-right mx-2">
                <?php if(!empty($role) && $role == 1):?>
                    <li class="nav-item active">
                        <a class="nav-link btn btn-outline-secondary ms-1 " href="../LikeJob/index.php?id=<?=$user_id?>">お気に入り</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link btn btn-outline-secondary ms-1 " href="../MessageRelation/messages.php">メッセージ</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link btn btn-outline-secondary ms-1 " href="../GeneralUser/index.php?id=<?=$user_id?>">マイページ</a>
                    </li>
                    <li class="nav-item active">
                      <form action="../Users/logout.php" method="POST">
                        <input  type="submit" name="logout"  class="btn btn-outline-secondary ms-1 p-2" value="ログアウト">
                      </form>
                    </li>
                <?php elseif(!empty($role) && $role == 2):?>
                    <li class="nav-item active">
                        <a class="nav-link btn btn-outline-secondary ms-1 " href="../Company/index.php">求職者一覧</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link btn btn-outline-secondary ms-1" href="../MessageRelation/messages.php">メッセージ</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link btn btn-outline-secondary ms-1" href="../Company/mypage.php">マイページ</a>
                    </li>
                    <li class="nav-item active ">
                        <form action="../Users/logout.php" method="POST">
                          <input type="submit" class="btn btn-outline-secondary ms-1 p-2" name="logout" value="ログアウト">
                        </form>
                    </li>
                <?php else:?>
                    <li class="nav-item active">
                        <a class="nav-link" href="../Users/login_form.php">ログイン</a>
                    </li>
                <?php endif;?>
            </ul>
        </div>
    </div>
</nav>

  