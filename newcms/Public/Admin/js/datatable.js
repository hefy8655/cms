$(function(){
	$('.table-sort').dataTable({
		"aaSorting": [[ 1, "asc" ]],//默认第几个排序
		"bStateSave": true,//状态保存
		"aoColumnDefs": [
		  {"orderable":false,"aTargets":[0]}// 制定列不参与排序
		],
		"bProcessing" : true, //开启读取服务器数据时显示正在加载中……特别是大数据量的时候，开启此功能比较好
		"aLengthMenu" : [5, 10, 20, 30, 40, 50, 100, 200], //更改显示记录数选项  
		"bPaginate" : true, //是否显示（应用）分页器 (左上角,右下角)
		"bLengthChange": true,//是否显示左上角下拉分页
		"bInfo" : true, //是否显示页脚信息，DataTables插件左下角显示记录数  
		"sPaginationType" : "full_numbers", //详细分页组，可以支持直接跳转到某页  
		"bSort" : true, //是否启动各个字段的排序功能  
		"bFilter" : true, //是否启动过滤、搜索功能
		"bSortClasses": false,//是否在当前被排序的列上额外添加sorting_1,sorting_2,sorting_3三个class，当该列被排序的时候，可以切换其背景颜色，该选项作为一个来回切换的属性会增加执行时间（当class被移除和添加的时候），当对大数据集进行排序的时候你或许希望关闭该选项
		// "iCookieDuration": 60*60*24, // 指定用于存储客户端信息到cookie中的时间长度，超过这个时间后，自动过期
		//因为设置了cookie保存时间，在这里改动的设置，需要把cookie清除才能看得到

	   //国际化配置  
		"oLanguage": {
			"sProcessing" : "正在获取数据，请稍后...",    
			"sLengthMenu" : "显示 _MENU_ 条",    
			"sZeroRecords" : "没有您要搜索的内容",    
			"sInfo" : "从 _START_ 到  _END_ 条记录 总记录数为 _TOTAL_ 条",    
			"sInfoEmpty" : "记录数为0",    
			"sInfoFiltered" : "(全部记录数 _MAX_ 条)",    
			"sInfoPostFix" : "",    
			"sSearch" : "从当前数据中检索：",    
			"sUrl" : "",    
			"oPaginate": {    
				"sFirst" : "第一页",
				"sPrevious" : "上一页",
				"sNext" : "下一页",
				"sLast" : "最后一页"
			}  
		},  
	});
}