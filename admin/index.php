<?php
include 'common.php';
include 'header.php';
include 'menu.php';

$stat = \Widget\Stat::alloc();
?>
<div class="main">
    <div class="container typecho-dashboard">
        <?php include 'page-title.php'; ?>
        <div class="row typecho-page-main">
            <div class="col-mb-12 welcome-board" role="main">
                <p><?php _e('<em>%s，欢迎回来！</em>',$user->screenName); ?><br>
                <?php _e('目前有 <em>%s</em> 篇文章, 并有 <em>%s</em> 条关于你的评论在 <em>%s</em> 个分类中.',
                        $stat->myPublishedPostsNum, $stat->myPublishedCommentsNum, $stat->categoriesNum); ?>
                    <br><br>
                <?php if($user->pass('editor', true) &&  $stat->waitingCommentsNum > 0): ?>
                        <b><a href="<?php $options->adminUrl('manage-comments.php?status=waiting'); ?>"><?php _e('待审核评论'); ?></a>
                            <span class="balloon" style=" background-color:red"><?php $stat->waitingCommentsNum(); ?></span>
                        </b>
                <?php elseif($stat->myWaitingCommentsNum > 0): ?>
                        <b><a href="<?php $options->adminUrl('manage-comments.php?status=waiting'); ?>"><?php _e('待审核的评论'); ?></a>
                            <span class="balloon" style=" background-color:red"><?php $stat->myWaitingCommentsNum(); ?></span>
                        </b>
                <?php endif; ?>&nbsp;&nbsp;
                
                <?php if($user->pass('editor', true) &&  $stat->WaitingPostsNum > 0): ?>
                    <b><a href="<?php $options->adminUrl('manage-posts.php?status=waiting'); ?>"><?php _e('待审核文章'); ?></a>
                            <span class="balloon" style=" background-color:red"><?php $stat->WaitingPostsNum(); ?></span>
                    </b>
                <?php elseif($stat->myWaitingPostsNum > 0): ?>
                        <b><a href="<?php $options->adminUrl('manage-posts.php?status=waiting'); ?>"><?php _e('待审核的文章'); ?></a>
                            <span class="balloon" style=" background-color:red"><?php $stat->myWaitingPostsNum(); ?></span>
                        </b>
                <?php endif; ?><br></p>
                
                <?php if ($user->logged > 0) {
                        $logged = new Typecho_Date($user->logged);
                        _e('最后登录: %s &nbsp;&nbsp;', $logged->word());
                        _e('最后登录IP: %s', $user->ip);
                    } ?>
                    
                <?php if ($user->group == 'subscriber'): ?>
                    <p style="color:red;"><?php _e('您当前没有权限发布文章，'); ?><a href="#"><?php _e('点击申请开启权限'); ?></a> </p>
                 <?php endif; ?>

                <ul id="start-link" class="clearfix">
                    <?php if ($user->pass('contributor', true)): ?>
                        <li><a href="<?php $options->adminUrl('write-post.php'); ?>"><?php _e('撰写新文章'); ?></a></li>
                        <?php if ($user->pass('editor', true) && 'on' == $request->get('__typecho_all_comments') && $stat->spamCommentsNum > 0): ?>
                            <li>
                                <a href="<?php $options->adminUrl('manage-comments.php?status=spam'); ?>"><?php _e('垃圾评论'); ?></a>
                                <span class="balloon"><?php $stat->spamCommentsNum(); ?></span>
                            </li>
                        <?php elseif ($stat->mySpamCommentsNum > 0): ?>
                            <li>
                                <a href="<?php $options->adminUrl('manage-comments.php?status=spam'); ?>"><?php _e('垃圾评论'); ?></a>
                                <span class="balloon"><?php $stat->mySpamCommentsNum(); ?></span>
                            </li>
                        <?php endif; ?>
                        <?php if ($user->pass('administrator', true)): ?>
                            <li><a href="<?php $options->adminUrl('themes.php'); ?>"><?php _e('更换外观'); ?></a></li>
                            <li><a href="<?php $options->adminUrl('plugins.php'); ?>"><?php _e('插件管理'); ?></a></li>
                            <li><a href="<?php $options->adminUrl('options-general.php'); ?>"><?php _e('系统设置'); ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                    <!--<li><a href="<?php $options->adminUrl('profile.php'); ?>"><?php _e('更新我的资料'); ?></a></li>-->
                </ul>
            </div>

            <div class="col-mb-12 col-tb-6" role="complementary">
                <?php if($user->pass('contributor', true)): ?>
                <section class="latest-link">
                    <h3><?php _e('最近发布的文章'); ?></h3>
                    <?php \Widget\Contents\Post\Recent::alloc('pageSize=10')->to($posts); ?>
                    <ul>
                        <?php if ($posts->have()): ?>
                            <?php while ($posts->next()): ?>
                                <li>
                                    <span><?php $posts->date('n.j'); ?></span>
                                    <a href="<?php $posts->permalink(); ?>" class="title"><?php $posts->title(); ?></a>
                                </li>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <li><em><?php _e('暂时没有文章'); ?></em></li>
                        <?php endif; ?>
                    </ul>
                </section>
                <?php endif; ?>
            </div>

            <div class="col-mb-12 col-tb-6" role="complementary">
                <?php if($user->pass('editor', true)): ?>
                <section class="latest-link">
                    <h3><?php _e('最近发布的评论'); ?></h3>
                    <ul>
                        <?php \Widget\Comments\Recent::alloc('pageSize=10')->to($comments); ?>
                        <?php if ($comments->have()): ?>
                            <?php while ($comments->next()): ?>
                                <li>
                                    <span><?php $comments->date('n.j'); ?></span>
                                    <a href="<?php $comments->permalink(); ?>"
                                       class="title"><?php $comments->author(false); ?></a>:
                                    <?php $comments->excerpt(35, '...'); ?>
                                </li>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <li><?php _e('暂时没有回复'); ?></li>
                        <?php endif; ?>
                    </ul>
                </section>
                <?php endif; ?>
            </div>

            <!--<div class="col-mb-12 col-tb-4" role="complementary">-->
            <!--    <section class="latest-link">-->
            <!--        <h3><?php _e('官方最新日志'); ?></h3>-->
            <!--        <div id="typecho-message">-->
            <!--            <ul>-->
            <!--                <li><?php _e('读取中...'); ?></li>-->
            <!--            </ul>-->
            <!--        </div>-->
            <!--    </section>-->
            <!--</div>-->
        </div>
    </div>
</div>

<?php
include 'copyright.php';
include 'common-js.php';
?>

<script>
    $(document).ready(function () {
        var ul = $('#typecho-message ul'), cache = window.sessionStorage,
            html = cache ? cache.getItem('feed') : '',
            update = cache ? cache.getItem('update') : '';

        if (!!html) {
            ul.html(html);
        } else {
            html = '';
            $.get('<?php $options->index('/action/ajax?do=feed'); ?>', function (o) {
                for (var i = 0; i < o.length; i++) {
                    var item = o[i];
                    html += '<li><span>' + item.date + '</span> <a href="' + item.link + '" target="_blank">' + item.title
                        + '</a></li>';
                }

                ul.html(html);
                cache.setItem('feed', html);
            }, 'json');
        }

        function applyUpdate(update) {
            if (update.available) {
                $('<div class="update-check message error"><p>'
                    + '<?php _e('您当前使用的版本是 %s'); ?>'.replace('%s', update.current) + '<br />'
                    + '<strong><a href="' + update.link + '" target="_blank">'
                    + '<?php _e('官方最新版本是 %s'); ?>'.replace('%s', update.latest) + '</a></strong></p></div>')
                    .insertAfter('.typecho-page-title').effect('highlight');
            }
        }

        // if (!!update) {
        //     applyUpdate($.parseJSON(update));
        // } else {
        //     $.get('<?php $options->index('/action/ajax?do=checkVersion'); ?>', function (o, status, resp) {
        //         applyUpdate(o);
        //         cache.setItem('update', resp.responseText);
        //     }, 'json');
        // }
    });

</script>
<?php include 'footer.php'; ?>
