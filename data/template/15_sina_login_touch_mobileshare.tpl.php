<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?><?php
$__CHARSET = CHARSET;$mobileshare = <<<EOF

<br/>
<a id="ak_rate" href="javascript:void((function(s,d,e,r,l,p,t,z,c,o) {var f='http://service.weibo.com/share/share.php?appkey={$this->adminsettings['appkey']}',u=z||d.location,p=['&url=',e(u),'&title=',e(t||d.title),'&ralateUid=',o||'','&sourceUrl=',e(l),'&content=',c||'{$__CHARSET}','&pic=',e(p||'')].join('');function a(){if(!window.open([f,p].join(''),'mb', ['toolbar=0,status=0,resizable=1,width=440,height=430,left=',(s.width- 440)/2,',top=',(s.height-430)/2].join('')))u.href=[f,p].join('');}; if(/Firefox/.test(navigator.userAgent)){setTimeout(a,0);}else{a();}}) (screen,document,encodeURIComponent,'','','{$pics}','{$message}','{$weibo_share_url}','{$__CHARSET}', ''));" onclick="setTimeout('forstat()', 0);"><i><img src="{$this->adminsettings['imgurl']}/icon_logo.png">&#20998;&#20139;&#21040;&#26032;&#28010;&#24494;&#21338;</i></a>

EOF;
?>
