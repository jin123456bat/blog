<?xml version="1.0" encoding="utf-8"?>
<?xml-stylesheet type="text/xsl" href="/css/rss_xml_style.css"?>
<rss version="2.0">
  <channel>
    <title>太客</title>
    <image>
      <title>太客</title>
      <link>http://www.techer.top</link>
      <url>http://mat1.qq.com/news/rss/logo_news.gif</url>
    </image>
    
    <description>太客</description>
    
    <link>http://news.qq.com/china_index.shtml</link>
    
    <copyright>Copyright 2017 - <?=date('Y')?> Techer. All Rights Reserved</copyright>
    
    <language>zh-cn</language>
    
    <generator>www.techer.top</generator>
    <?php foreach ($article as $a){?>
    <item>
      <title><?=$a['title']?></title>
      <link>http://www.techer.top/index.php?c=article&a=index&id=<?=$a['id']?></link>
      <author><?=$a['uname']?></author>
      <category/>
      <pubDate><?=$a['createtime']?></pubDate>
      <comments/>
      <description><?=$a['summary']?></description>
    </item>
    <?php }?>
  </channel>
</rss>