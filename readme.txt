--------------
imGlossary
--------------

- This is a RC version, what means that it's meant for testing purposes only.
- Enjoy imGlossary!!!

/**
 * $Id: readme.txt 12 October 2008 McDonald Exp $
 * Module: imGlossary
 * Version: v 1.00
 * Release Date: 24 October 2008
 * Author: McDOnald
 * Licence: GNU
 */


-------------
Introduction:
-------------
Thanks for giving imGlossary a chance. This little module has a single purpose: to help you build in your site a nice glossary, one in which you can choose to have a single category or many categories (glossaries).

This module was built using ImpressCMS 1.1 RC2 as test bed, and includes syntax that will probably need a not-too-old version of PHP. It's based on Wordbook 1.16, in turn based on Catzwolf's module called WF-FAQ, with many, many changes. But it does have a couple of good features: it uses Smarty templates and it's fully searchable (it even includes its own search function).


--------------
How to install
--------------
imGlossary is installed as a regular ICMS module, which means you should copy the complete 'modules/imglossary' folder into the '/modules' directory of your website. Then log in to your site as administrator, go to System Admin > Modules, look for the imGlossary icon in the list of uninstalled modules and click the install icon. Follow the directions in the screen and you'll be ready to go.


--------
RSS Feed
--------
To be able to use RSS feed with ImpressCMS 1.1 you have to apply to following fix to the file <your_url>/class/icmsfeed.php:

Find this code in the file:
         function render() {
		//header ('Content-Type:text/xml; charset='._CHARSET);
		$xoopsOption['template_main'] = "db:system_rss.html";
		$tpl = new XoopsTpl();
		
Now add the line just before '//header .. ' as showed below:
         function render() {
		include_once ICMS_ROOT_PATH . '/class/template.php';
		//header ('Content-Type:text/xml; charset='._CHARSET);
		$xoopsOption['template_main'] = "db:system_rss.html";
		$tpl = new XoopsTpl();
		
Save the file and upload the file to your server.
The RSS feed doesn't work when your logged in with debug on.


--------
Feedback
--------
As every other man, I'd like to know if this module is useful to you, if it has any bugs, if it can be in any way improved.
In any of these circumstances, don't hesitate to post them in the:
- ImpressCMS Support Forum: http://community.impresscms.org/modules/newbb/index.php?cat=3
- SourceForge Module Bug Tracker: http://sourceforge.net/tracker/?atid=1064496&group_id=205633&func=browse



-=| McDonald |=-
