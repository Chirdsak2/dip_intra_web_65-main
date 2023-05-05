<?php
include("../EWT_ADMIN/comtop.php");
// include("../assets/class/module/article.class.php");
include("menu-top.php");
$db->query("USE ".$EWT_DB_USER);
$nid = (int)(!isset($_GET['nid']) ? '' : $_GET['nid']);

// $article = new article();
// $article_list = $article->getAricleList($nid);
// $article_list_detail = $article->getArticleListDetail($nid, null);
?>

<style>
    .article--topic-name {
        font-size: 30px;
        padding: 10px 0px;
    }

    .gal {
        margin-bottom: 30px;
        -webkit-column-count: 3;
        -moz-column-count: 3;
        column-count: 3;
    }

    .gal img {
        width: 100%;
        margin-bottom: 15px;
        border-radius: 5px;
    }

    .gal figure figcaption {
        display: none;
    }

    figure {
        margin: 0 0 1rem;
    }
</style>

<div class="container-fluid">
    <?php include("menu-top.php"); ?>

    <div class="row m-b-sm">
        <div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
            <!--start card -->
            <div class="card">
                <!--start card-header -->
                <!-- <div class="card-header">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
                            <h4><?php echo $txt_article_list; ?></h4>
                            <p></p>
                        </div>
                    </div>
                </div> -->

                <div class="card-body">
                    <div id="nav" style="position:absolute;width:400px;z-index:1;display:none"></div>

                    <!-- <div class="article--topic-name"><?php echo trim($article_list["data"][0]['n_topic']); ?></div> -->

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <?php echo $article_list_detail['txt_detail']; ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <?php echo $article_list_detail['txt_image']; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php
include("../EWT_ADMIN/combottom.php");
?>