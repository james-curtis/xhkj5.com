<?php

/**

 * 

 * 信偶网提醒：为保证信偶网资源的更新维护保障，防止信偶网首发资源被恶意泛滥，

 *             希望所有下载信偶网资源的会员不要随意把信偶网首发资源提供给其他人;

 *             如被发现，将取消信偶网VIP会员资格，停止一切后期更新支持以及所有补丁BUG等修正服务；

 *          

 * 信偶网出品 必属精品

 * 信偶网源码论坛 全网首发 http://www.5dzy.cc

 * 官网：www.5dzy.cc (请收藏备用!)

www.5dzy.cc

 * 谢谢支持，感谢你对信偶网源码论坛的关注和信赖！！！   

 * 

 */



if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {

	exit('Access Denied');

}

$setting = $_G['cache']['plugin']['k_misign'];

$op = in_array($_GET['op'], array('add', 'edit', 'addkami')) ? $_GET['op'] : '';



if($op == ''){

	if(!submitcheck('pushsubmit')) {

		$perpage = 30;

		$page = intval($_GET['page']);

		$start = ($page-1) * $perpage;

		if(empty($page)){

			$page = 1;

		}

		if($start < 0){

			$start = 0;

		}

		$multi = '';

		$list = C::t("#k_misign#plugin_k_misign_push")->fetch_all_cp($start, $perpage);

		foreach($list as $lists){

			$lists['dateline'] = dgmdate($lists['dateline'], 'u');

			$companylist .= showtablerow('', array('', 'class="td29"', '', ''), array(

				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[".$lists['pushid']."]\" value=\"".$lists['pushid']."\">",

				$lists['title'],

				$lists['dateline'],

				"<a href=\"".ADMINSCRIPT."?action=plugins&operation=config&do=".$pluginid."&identifier=k_misign&pmod=cp_push&op=edit&pushid=".$lists['pushid']."\" class=\"act\">".$lang['detail']."</a>",

			), TRUE);

		}

		$count =  0;

		$count = C::t("#k_misign#plugin_k_misign_push")->count();

		$multi = multi($count, $perpage, $page, '?action=plugins&operation=config&do='.$pluginid.'&identifier=k_misign&pmod=cp_push');

	

		showformheader('plugins&operation=config&do='.$pluginid.'&identifier=k_misign&pmod=cp_push');

		showtableheader('', 'fixpadding', '');

		showsubtitle(array('', $lang['name'], $lang['dateline'], ''));

		echo $companylist;

		echo '<tr><td>&nbsp;</td><td colspan="8"><div><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=k_misign&pmod=cp_push&op=add" class="addtr">'.lang('plugin/k_misign', 'push_add').'</a></div></td></tr>';

		showsubmit('pushsubmit', $lang['submit'], 'del', '', $multi);

		showtablefooter();

		showformfooter();

	}else{

		if(is_array($_GET['delete'])) {

			foreach($_GET['delete'] as $id) {

				C::t("#k_misign#plugin_k_misign_push")->delete($id);

			}

		}

		cpmsg(cplang(lang('plugin/k_misign', 'success')), "action=plugins&operation=config&do=".$do."&identifier=k_misign&pmod=cp_push", 'succeed');

	}

}elseif($op == 'add'){

	require_once libfile('function/forum');

	if(!submitcheck('addsubmit')) {

		showformheader('plugins&operation=config&do='.$pluginid.'&identifier=k_misign&pmod=cp_push&op=add', "enctype");

		showtableheader(lang('plugin/k_misign', 'push_add'), 'fixpadding', '');

		showsetting(lang('plugin/k_misign', 'push_title'), 'titlenew', $push['title'], 'text');

		showsetting(lang('plugin/k_misign', 'push_message'), 'messagenew', $push['message'], 'textarea');

		showsetting(lang('plugin/k_misign', 'push_pic'), 'picnew', $push['pic'], 'filetext', '', 0, $pichtml.lang('plugin/k_misign', 'push_pic_tips'));

		showsetting(lang('plugin/k_misign', 'push_url'), 'urlnew', $push['url'], 'text');

		showsubmit('addsubmit', 'submit');

		showtablefooter();

		showformfooter();

	}else{

		if($_FILES['picnew']) {

			$logodata = array('extid' => 'k_misign_pic');

			$_GET['picnew'] = 'common/'.upload_icon_banner($logodata, $_FILES['picnew'], '');

		}

		$data = array(

			'pic'=>addslashes($_GET['picnew']), 

			'title'=>addslashes($_GET['titlenew']),

			'message'=>addslashes($_GET['messagenew']),

			'url'=>addslashes($_GET['urlnew']),

			'dateline'=>$_G['timestamp'],

		);

		C::t("#k_misign#plugin_k_misign_push")->insert($data);

		cpmsg(cplang(lang('plugin/k_misign', 'success')), "action=plugins&operation=config&do=".$do."&identifier=k_misign&pmod=cp_push", 'succeed');

	}

}elseif($op == 'edit'){

	$pushid = intval($_GET['pushid']);

	require_once libfile('function/forum');

	if(!submitcheck('addsubmit')) {

		$push = C::t("#k_misign#plugin_k_misign_push")->fetch_by_pushid($pushid);

		if($push['pic']) {

			$valueparse = parse_url($push['pic']);

			if(isset($valueparse['host'])) {

				$companylogo = $push['pic'];

			} else {

				$companylogo = $_G['setting']['attachurl'].$push['pic'].'?'.random(6);

			}

			$pichtml = '<img src="'.$companylogo.'" />';

		}

		showformheader('plugins&operation=config&do='.$pluginid.'&identifier=k_misign&pmod=cp_push&op=edit&pushid='.$pushid, "enctype");

		showtableheader(lang('plugin/k_misign', 'push_add'), 'fixpadding', '');

		showsetting(lang('plugin/k_misign', 'push_title'), 'titlenew', $push['title'], 'text');

		showsetting(lang('plugin/k_misign', 'push_message'), 'messagenew', $push['message'], 'textarea');

		showsetting(lang('plugin/k_misign', 'push_pic'), 'picnew', $push['pic'], 'filetext', '', 0, $pichtml.lang('plugin/k_misign', 'push_pic_tips'));

		showsetting(lang('plugin/k_misign', 'push_url'), 'urlnew', $push['url'], 'text');

		showsubmit('addsubmit', 'submit');

		showtablefooter();

		showformfooter();

	}else{

		if($_FILES['picnew']) {

			$logodata = array('extid' => 'k_misign_pic');

			$_GET['picnew'] = 'common/'.upload_icon_banner($logodata, $_FILES['picnew'], '');

		}

		$data = array(

			'pic'=>addslashes($_GET['picnew']), 

			'title'=>addslashes($_GET['titlenew']),

			'message'=>addslashes($_GET['messagenew']),

			'url'=>addslashes($_GET['urlnew']),

			'dateline'=>$_G['timestamp'],

		);

		C::t("#k_misign#plugin_k_misign_push")->update($pushid, $data);

		cpmsg(cplang(lang('plugin/k_misign', 'success')), "action=plugins&operation=config&do=".$do."&identifier=k_misign&pmod=cp_push", 'succeed');

	}

}

//From:www_lbw3_co

?>
