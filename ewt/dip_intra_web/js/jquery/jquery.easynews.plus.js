// Easy News - jQuery plugin for News Slide by Michael Lo
// http://www.ezjquery.com
// Copyright (c) 2007 Michael Lo
// Dual licensed under the MIT and GPL licenses.
// http://www.opensource.org/licenses/mit-license.php
// http://www.gnu.org/licenses/gpl.html
// free for anyone like Jquery. Enjoy!
(function($) {
	jQuery.extend({
		init_plus: function(option) {
		
			option = $.extend({
				firstname:"",
				secondname:"",
				thirdname:"",
				fourthname:"",
				playingtitle:"Now Playing:",
				nexttitle:"Next News:",
				prevtitle:"Prev News:",
				newsspeed:6000,
				table_width:350,
				table_height:350,
				isauto:1,
				bid:"",
				imagedir:""
			}, option);

			var firstname=option.firstname;
			var secondname=option.secondname;
			var thirdname=option.thirdname;
			var fourthname=option.fourthname;
			var newsspeed=option.newsspeed;
			var bid=option.bid;
			var isauto=option.isauto;
			var table_width=option.table_width;
			var table_height=option.table_height;
			var playingtitle=option.playingtitle;
			var nexttitle=option.nexttitle;
			var prevtitle=option.prevtitle;
			var imagedir=option.imagedir;
			var myprevimg=$('#news_prev').attr('src'); if (!myprevimg){myprevimg=imagedir+'prev.gif';}
			var mynextimg=$('#news_next').attr('src'); if (!mynextimg){mynextimg=imagedir+'next.gif';}
			var mypauseimg=$('#news_pause').attr('src'); if (!mypauseimg){mypauseimg=imagedir+'pause.gif';}

			var myprevimg0=$('#news_prev0').attr('src'); if (!myprevimg0){myprevimg0=imagedir+'prev.gif';}
			var mynextimg0=$('#news_next0').attr('src'); if (!mynextimg0){mynextimg0=imagedir+'next.gif';}
			var mypauseimg0=$('#news_pause0').attr('src'); if (!mypauseimg0){mypauseimg0=imagedir+'pause.gif';}


			var activechk,activechkmore,mysize,myfirst,myfirst_explain,active,timer,nextnum;
			mysize=$('#'+firstname+' .news_style').size();
			myfirst=$('#'+firstname+' .news_style').eq(0).html();
			myfirst_explain=$('#'+firstname+' .news_style').eq(1).attr('rel');
			active=0;
			$('#'+secondname).append('<table border=0 id=mm'+firstname+' class=news_move cellspacing="0" cellpadding="0"><tr id=insidetr'+secondname+'></tr></table>');
			$('#insidetr'+secondname).append('<td class=mytable id='+secondname+active+'>'+myfirst+'</td>');
			$('#'+thirdname).html('&nbsp;&nbsp;'+playingtitle+'1/'+mysize+'&nbsp;&nbsp;<br>');
			$('#'+thirdname).append(nexttitle+myfirst_explain);

/////////////////////////////////////////Next Click////////////////////////////////////////////////////////////////////////////////
			$('#'+fourthname+' #news_next').click(function() {
				clearTimeout(timer);
				$(this).attr({src:mynextimg0});
				$('#'+fourthname+' #news_prev').attr({src:myprevimg});
				$('#'+fourthname+' #news_pause').attr({src:mypauseimg});
				var need_to_delete='#'+secondname+active;
				active=active+1;
				if (active==mysize) { active=0; }
				var mynum=active+1;
				var nextnum=mynum;
				var temp=$('#'+firstname+' .news_style').eq(active).html();
				if (nextnum==mysize) { nextnum=0; }
				var mynow_explain=$('#'+firstname+' .news_style').eq(nextnum).attr('rel');
				$('#insidetr'+secondname).append('<td class="abctable'+bid+'" id='+secondname+active+'>'+temp+'</td>');
				$('#'+thirdname).html('&nbsp;&nbsp;'+playingtitle+''+mynum+'/'+mysize+'&nbsp;&nbsp;<br>');
				$('#'+thirdname).append(nexttitle+mynow_explain);
				var whatdist=$('#'+secondname+active).css("width");
				whatdist=parseInt(whatdist,10);
				$('#mm'+firstname).animate({left:-table_width},500,function(){
					$(need_to_delete).remove();
					$('#mm'+firstname).css({left:'0'});	
				});
				if(isauto==1) {
					timer=setTimeout(autonext,newsspeed,active);
				}
				$(".headgroupshow").html($('#'+firstname+' .headgroup').eq(active).html());
			});
/////////////////////////////////////////prev click///////////////////////////////////////////////////////////////////////////////////
			$('#'+fourthname+' #news_prev').click(function(){
				clearTimeout(timer);
				$(this).attr({src:myprevimg0});
				$('#'+fourthname+' #news_next').attr({src:mynextimg});
				$('#'+fourthname+' #news_pause').attr({src:mypauseimg});
				var need_to_delete='#'+secondname+active;
				active=active-1;
				if (active<0){active=mysize-1;}
				var mynum=active+1;
				var myprevnum=mynum-2;
				if (myprevnum<0){myprevnum=mysize-1;}	
				var temp=$('#'+firstname+' .news_style').eq(active).html();
				if (nextnum==mysize){nextnum=0;}	
				var mynow_explain=$('#'+firstname+' .news_style').eq(myprevnum).attr('rel');
				$('#insidetr'+secondname).prepend('<td class=abctable'+bid+' id='+secondname+active+'>'+temp+'</td>');
				var whatdist=$('#'+secondname+active).css("width");
				whatdist=parseInt(whatdist,10);
				$('#mm'+firstname).css({left:-table_width});
				$('#'+thirdname).html('&nbsp;&nbsp;'+playingtitle+''+mynum+'/'+mysize+'&nbsp;&nbsp;<br>');
				$('#'+thirdname).append(prevtitle+mynow_explain);
				$('#mm'+firstname).animate({left:0},500,function(){
					$(need_to_delete).remove();
				});
				if (isauto==1) {
					timer=setTimeout(autoprev,newsspeed,active);
				}
				$(".headgroupshow").html($('#'+firstname+' .headgroup').eq(active).html());
			});
//////////////////////////Pause Click//////////////////////////////////////////////////////////////
			$('#'+fourthname+' #news_pause').click(function(){
				$(this).attr({src:mypauseimg0});
				$('#'+fourthname+' #news_next').attr({src:mynextimg});
				$('#'+fourthname+' #news_prev').attr({src:myprevimg});
				clearTimeout(timer);
			});
//////////////////////////Addtion Function//////////////////////////////////////////////////////////////
			var _st = window.setTimeout; 
			window.setTimeout = function(fRef, mDelay) { 
				if(typeof fRef == 'function'){ 
					var argu = Array.prototype.slice.call(arguments,2); 
					var f = (function(){ fRef.apply(null, argu); }); 
					return _st(f, mDelay); 
				} 
				return _st(fRef,mDelay); 
			}; 
			
//////////////////////////Auto Next//////////////////////////////////////////////////////////////
			function autonext(q){
				if (!q){q=0;}
				myend=$('#'+firstname+' .news_hide_style').size();
				myend=myend-1;
				if (q >= myend){q=0;}
				$('#'+fourthname+' #news_next').eq(q).click();
				q=q+1;					
			}
//////////////////////////Auto Prev//////////////////////////////////////////////////////////////
			function autoprev(q){
				if (!q){q=0;}
				myend=$(".news_hide_style").size();
				myend=myend-1;
				if (q >= myend){q=0;}
				$('#'+fourthname+' #news_prev').eq(q).click();
				q=q+1;					
			}
//////////////////////////Init AutoPlay//////////////////////////////////////////////////////////////
			if (isauto==1) {
				timer=setTimeout(autonext,newsspeed,1);
			}
		}
	});
})(jQuery);