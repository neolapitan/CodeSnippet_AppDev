<?php

    session_start();

    include("../connections.php");

    if(isset($_SESSION["email"])){
        $email = $_SESSION["email"];
    }


    $id = $title = $desc = $lang = $code = "";
    $title_err = $desc_err = $lang_err = $code_err = "";

    function connect(){
        $dsn = "mysql:host=localhost;dbname=my_db";
        $user = "root";
        $passwd = "";
        $c = new PDO($dsn, $user, $passwd);
        return $c;
    }


    function snip_save($email, $title, $desc, $lang, $code, $id){
        $c = connect();
        if($id){
            $sql = "UPDATE snippet SET `title`=?, `description`=?, `language`=?, `code`=? WHERE id=?";
            $query = $c->prepare($sql);
            $query->execute([$title, $desc, $lang, $code, $id]);
            return $id;
        }else{
            $sql = "INSERT INTO snippet (`email`,`title`,`description`,`language`,`code`) VALUES (?,?,?,?,?)";
            $query = $c->prepare($sql);
            $query->execute([$email, $title, $desc, $lang, $code]);
            return $c->lastInsertId();
        }
    }

    function retrieve($email){
        $results = [];
        try {
            $c = connect();
            $results = $c->query("SELECT * from snippet WHERE email='$email'");
        }catch (Exception $e){

        }
        return $results;
    }

    function snip_get($id){
        $results = [];
        try{
            $c = connect();
            $query = $c->prepare("SELECT * from snippet WHERE id=? LIMIT 1");
            $query->execute([$id]);
            $results = $query->fetchAll();
            if(isset($results[0])){
                $results = $results[0];
            }else{
                $results = [];
            }
        }catch (Exception $e){

        }
        return $results;
    }

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $data = snip_get($id);
        if($data){
            $title = $data["title"];
            $desc = $data["description"];
            $lang = $data["language"];
            $code = $data["code"];
        }
    }

    if(isset($_POST['archive'])){

        $title = isset($_POST['title']) ? $_POST['title'] : null;
        $desc = isset($_POST['description']) ? $_POST['description'] : null;
        $lang = isset($_POST['language']) ? $_POST['language'] : null;
        $code = isset($_POST['code']) ? $_POST['code'] : null;
        
        if(empty($_POST["title"])){
            $title_err = "Required!";
        }

        if(empty($_POST["description"])){
            $desc_err = "Required!";
        }

        if(empty($_POST["language"])){
            $lang_err = "Required!";
        }

        if(empty($_POST["code"])){
            $code_err = "Required!";
        }

        if($title && $desc && $lang && $code){
            $id = snip_save($email,$title, $desc, $lang, $code, $id);
        }

    }

    if(isset($_POST['delete'])){
        
        if($id){
            $conn = connect();
            $query = $conn->prepare("DELETE FROM snippet WHERE id= ?");
            $query->execute([$id]);
            header("Location: app.php");
            exit();
        }

    }

?>

<script>
    function night() {
        var element = document.body;
        element.classList.toggle("blackout");
    }

    function copy() {
        var copyText = document.getElementById("input");
        copyText.select();
        navigator.clipboard.writeText(copyText.value);
        alert("Copied to clipboard");
    }
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CodeSnippet</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.6/styles/gruvbox-dark.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.6/highlight.min.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
</head>

<body>

    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="container-fluid">
            <a id="liveToastBtn" class="navbar-brand float-md-start mb-0" href="#">Code<span style="color:green">Snippet</span></a>
            <div class="nav nav-masthead justify-content-center float-md-end">
            <a class="btn btn-m btn-danger fw-bold ms-1" aria-current="page" href="../logout">Logout</a>
            </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="form-container">
            <div class="form-content">
                <form  method="POST">
                <br>
                <br>
                <a class="btn btn-secondary" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                Saved Snippets
                </a>
                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Saved Snippets</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div class="list-group list-group-flush">
                        <?php foreach (retrieve($email) as $snip):?>
                            <a class="list-group-item" href="app.php?id=<?php echo htmlentities($snip["id"]);?>"><?php echo $snip["title"];?></a></li>
                        <?php endforeach;?>
                    </div>
                </div>
                </div>
            
                <a class="btn btn-secondary" href="app.php">New Snippet</a>
                <br>
                <br>
                <input class="form-control" value="<?php echo $title;?>" placeholder="Enter title" type="text" name="title" autocomplete="off"/><span class="error"><?php echo $title_err; ?></span><br>
                <input class="form-control" value="<?php echo $desc;?>" placeholder="Enter description" type="text" name="description" autocomplete="off"/><span class="error"><?php echo $desc_err; ?></span><br>
                <select class="form-select" name="language">
                    <option>--Programming language--</option>
                    <option value="C" <?php if($lang=="C"){ echo "selected"; }?> >C</option>
                    <option value="C++" <?php if($lang=="C++"){ echo "selected"; }?>>C++</option>
                    <option value="C#" <?php if($lang=="C"){ echo "selected"; }?> >C#</option>
                    <option value="HTML" <?php if($lang=="HTML"){ echo "selected"; }?> >HTML</option>
                    <option value="Java" <?php if($lang=="Java"){ echo "selected"; }?> >Java</option>
                    <option value="JavaScript" <?php if($lang=="JavaScript"){ echo "selected"; }?> >JavaScript</option>
                    <option value="PHP" <?php if($lang=="PHP"){ echo "selected"; }?> >PHP</option>
                    <option value="Python" <?php if($lang=="Python"){ echo "selected"; }?> >Python</option>
                    <option value="SQL" <?php if($lang=="SQL"){ echo "selected"; }?> >SQL</option>
                    <option value="Other" <?php if($lang=="Other"){ echo "selected"; }?> >Other</option>
                    </select><span class="error"><?php echo $lang_err; ?></span>
                    <br>           
                    <textarea id="input" class="form-control" name="code" placeholder="Code" cols="60" rows="10"><?php echo $code;?></textarea><br>
                    <span class="error"><?php echo $code_err; ?></span><br>
                    <?php if($id):?>
                        <button class="btn btn-danger" name="delete">Delete</button>
                    <?php endif;?>
                    <button type="submit" class="btn btn-success" name="archive">Archive</button>

                </form>
            </div>
    </div>

    <div class="view-container">
        <br>
        <br>
        <h2 class="text-center">Your Snippet</h2>
            <p class="fw-normal">Title: <?php echo htmlentities($title);?></p>
            <p class="fw-normal">Description: <?php echo htmlentities($desc);?></p>
            <img src="../Photos/clipboard.svg" onclick="copy()">
            
            <div class="code-block">
                <pre>
                    <code class="language-<?php echo htmlentities($lang);?>"><?php echo htmlentities($code);?></code>
                </pre>
            </div>
    </div>

    <img src="../Photos/dark-mode.png" onclick="night()" width="20" height="20" fill="currentColor" class="position-fixed bottom-0 end-0 me-2 mb-2">

    </div>

    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>