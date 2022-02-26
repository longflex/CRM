<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
	<meta name="_token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   
  </head>
  <body>
    
    <div class="row m-none">
      
     
      <div class="modal-header mb-20">
        <h4 class="modal-title">Delivery Details</h4>
      </div>
    
      <!--report-chart-->
      <div class="iframe-half-div">
       <table class="table table-bordered">
    <thead>
      <tr class="table_heading">
        <th width="50%">Status</th>
       
        <th width="50%">Count</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Rejected</td>
        <td>{{ $rejected }}</td>
      </tr>
      <tr>
        <td>Delivered</td>
        <td>{{ $delivered }}</td>
      </tr>
       <tr>
        <td>Failed</td>
        <td>{{ $failed }}</td>
      </tr>
       <tr>
        <td>Rejected Retry</td>
        <td>{{ $rejected_retry }}</td>
      </tr>
       <tr>
        <td>Failed Retry</td>
        <td>{{ $failed_retry }}</td>
      </tr>
       <tr>
        <td>Auto Failed</td>
        <td>{{ $auto_failed }}</td>
      </tr>
       <tr>
        <td>Block</td>
        <td>{{ $block }}</td>
      </tr>
      
       <tr>
        <td><b>Total</b></td>
        <td><b>{{ $total }}</b></td>
      </tr>
      
    </tbody>
  </table>
  
  <button type="submit" class="theme-btn">Resend</button>
  
  <button type="submit" class="theme-btn red">Delete</button>
  
      </div>
      
      <div class="iframe-half-div">
      
      
      <!--pie_chart-->								
<div id="canvas-holder" style="width: 200px; margin-left:auto; margin-right:auto;">
<canvas id="chart-area1" width="200" height="200" />
</div>

<div class="pie_value">
<ul>
<li><span style="background:#efcd64;"></span> Rejected </li>
<li><span style="background:#e25f07;"></span> Delivered</li>
<li><span style="background:#ad0404;"></span> Failed</li>
<li><span style="background:#1c439e;"></span> Rejected Retry</li>
<li><span style="background:#00ccff;"></span> Failed Retry</li>
<li><span style="background:#00ffba;"></span> Auto Failed</li>
<li><span style="background:#8be300;"></span> Block</li>
</ul>
</div>
<!--pie_chart-->
      
      
      </div>
      <!--report-chart-->
    
      <!--divider-->
      <div class="iframe-full-div ">  
      <div class="modal-content-divider"></div>
      </div>
      <!--divider-->
        
      <!--message-->
      <div class="iframe-full-div">
      <h4 class="m_head">Message</h4>
      
      <span>
      {{ $msg }} 
      </span>
      </div>
      <!--message-->
      
      <!--divider-->
      <div class="iframe-full-div ">  
      <div class="modal-content-divider"></div>
      </div>
      <!--divider-->
      
      <!--contact-list-->
       <div class="iframe-full-div ">
       <div class="table-responsive padding_right_5">
       
      <div class="pull-left">
		  <input type="text" class="inp frame-inp-table"  placeholder="Search receiver." name="search_text" id="search_text" autocomplete="off"/>
		  <input type="hidden"  name="res_id" id="res_id" value="{{ $resid }}" />
      </div>
       <table class="table table-bordered margin_none">
    <thead>
      <tr class="table_heading">
        <th width="8%" class="text-center">S.No.</th>
        <th width="16%">Receiver</th>
        <th>Status</th>
        <th width="35%">Delevery Time</th>
      </tr>
    </thead>
    <tbody class="read">
	@foreach($reports as $key=>$val)
      <tr>
        <td align="center">{{ ++$key }}</td>
        <td>{{ $val->receiver }}</td>
        <td>{{ $val->description }}</td>
        <td>{{ $val->created_at }}</td>
      </tr>
      @endforeach
     
    </tbody>
  </table>
  {{ $reports->links() }}
  </div>
  </div>
      <!--contact-list-->
</div>    
<!--new-pie-->
<link href="{{ asset(Laralum::publicPath() .'/css/font-awesome.min.css') }}" type="text/css" rel="stylesheet">
<link href="{{ asset(Laralum::publicPath() .'/bootstrap/css/bootstrap.min.css') }}" type="text/css" rel="stylesheet">
<link href="{{ asset(Laralum::publicPath() .'/css/responsive-table.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset(Laralum::publicPath() .'/css/custom.css') }}" type="text/css" rel="stylesheet" />
<script src="{{ asset(Laralum::publicPath() .'/js/Chart.bundle.js') }}"></script>
<script src="{{ asset(Laralum::publicPath() .'/js/jquery-3.0.0.min.js') }}"></script>
<script type="text/javascript">
$(function(){
 $('#search_text').keyup(function(){
	        var my_url = "{{ url('sms/admin/detailsSearchAction') }}";
            var search = $(this).val();
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
				}
			})
		if(search.length>4 || search.length==''){
			var res_id = $("#res_id").val();
			$('#search_text').addClass('loadinggif');
            $.ajax({
                url     : my_url,
                type    : "POST",
                data    : {
                    'search':   search,
					'res_id':   res_id
                },
				
                success: function(search){
                    $('.read').html(search);
					$('#search_text').removeClass('loadinggif');
                }
            });
		}
        });
});

</script>
<script>
Chart.defaults.global.tooltips.custom = function(tooltip) {

// Tooltip Element
var tooltipEl = $('#chartjs-tooltip');

if (!tooltipEl[0]) {
$('body').append('');
tooltipEl = $('#chartjs-tooltip');
}

// Hide if no tooltip
if (!tooltip.opacity) {
tooltipEl.css({
opacity: 0
});
$('.chartjs-wrap canvas')
.each(function(index, el) {
$(el).css('cursor', 'default');
});
return;
}

$(this._chart.canvas).css('cursor', 'pointer');

// Set caret Position
tooltipEl.removeClass('above below no-transform');
if (tooltip.yAlign) {
tooltipEl.addClass(tooltip.yAlign);
} else {
tooltipEl.addClass('no-transform');
}

// Set Text
if (tooltip.body) {
var innerHtml = [
(tooltip.beforeTitle || []).join('\n'), (tooltip.title || []).join('\n'), (tooltip.afterTitle || []).join('\n'), (tooltip.beforeBody || []).join('\n'), (tooltip.body || []).join('\n'), (tooltip.afterBody || []).join('\n'), (tooltip.beforeFooter || [])
.join('\n'), (tooltip.footer || []).join('\n'), (tooltip.afterFooter || []).join('\n')
];
tooltipEl.html(innerHtml.join('\n'));
}

// Find Y Location on page
var top = 0;
if (tooltip.yAlign) {
if (tooltip.yAlign == 'above') {
top = tooltip.y - tooltip.caretHeight - tooltip.caretPadding;
} else {
top = tooltip.y + tooltip.caretHeight + tooltip.caretPadding;
}
}

var position = $(this._chart.canvas)[0].getBoundingClientRect();

// Display, position, and set styles for font
tooltipEl.css({
opacity: 1,
width: tooltip.width ? (tooltip.width + 'px') : 'auto',
left: position.left + tooltip.x + 'px',
top: position.top + top + 'px',
fontFamily: tooltip._fontFamily,
fontSize: tooltip.fontSize,
fontStyle: tooltip._fontStyle,
padding: tooltip.yPadding + 'px ' + tooltip.xPadding + 'px',
});
};

var config = {
type: 'pie',
data: {
datasets: [{
data: [{{ $str }}],
backgroundColor: [
"#efcd64",
"#e25f07", 
"#ad0404",
"#1c439e",
"#00ccff",
"#00ffba",
"#8be300",
],
}],
labels: [
"Rejected",
"Delivered",
"Failed",
"Rejected Retry",
"Failed Retry",
"Auto Failed",
"Block"
]
},
options: {
responsive: true,
legend: {
display: false
},
tooltips: {
enabled: true,
}
}
};

window.onload = function() {
var ctx1 = document.getElementById("chart-area1").getContext("2d");
window.myPie = new Chart(ctx1, config);

var ctx2 = document.getElementById("chart-area2").getContext("2d");
window.myPie = new Chart(ctx2, config);
};
</script>
<!--new--pie-->
<style>
  .loadinggif {
    background:url('{{ asset(Laralum::publicPath() .'/images/ajax-loader.gif') }}') no-repeat right center;
}
  </style>
    
  </body>
</html>