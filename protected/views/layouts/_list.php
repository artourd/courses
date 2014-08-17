<ul class="article-list">
    <?php if ($articles) foreach ($articles as $article): ?>
        <li class="article-list_item  tile post-tile">
            <article class="article article--micro  category-design " data-disqus-id="http://www.sitepoint.com/5-sites-fantastic-creative-commons-design-resources/">
                <header class="article_category"><h2 class="article_category_title"><a href="http://www.sitepoint.com/design/"><?=$article->product->title?></a></h2></header>

                <section class="article_header">
                    <h1 class="article_title"><a href="http://www.sitepoint.com/5-sites-fantastic-creative-commons-design-resources/"><?=$article->title?></a></h1>
                    <div class="contributor article_contributor">
                        <p class="contributor_name article_author-name">
                            <?php if ($article->tags) foreach ($article->tags as $tag): ?>
                            <span><?=$tag->name?></span>
                            <?php endforeach; ?>
                        </p>
                    </div>

                    <div class="article_meta-data"><p class="article_pub-date"><time datetime="2014-07-29 09:28:44" pubdate>Jul 29, 2014</time></p></div>
                </section>
            </article>
        </li>  
    <?php endforeach; ?>
</ul>

<div class="pagination-type2">
    <span class="button btn-active secondary radius">1</span><a class="button secondary radius" href="http://www.sitepoint.com/page/2/">2</a><a class="button secondary radius" href="http://www.sitepoint.com/page/3/">3</a><a class="button secondary radius" href="http://www.sitepoint.com/page/4/">4</a><a class="button secondary radius" href="http://www.sitepoint.com/page/5/">5</a><a class="button secondary radius" href="http://www.sitepoint.com/page/6/">6</a><a class="button secondary radius" href="http://www.sitepoint.com/page/7/">7</a><a class="button secondary radius" href="http://www.sitepoint.com/page/8/">8</a><a class="button secondary radius" href="http://www.sitepoint.com/page/9/">9</a><a class="button secondary radius" href="http://www.sitepoint.com/page/10/">10</a><a class="button btn-next secondary radius" href="http://www.sitepoint.com/page/2/">Next</a>  
</div>
