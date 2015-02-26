<script language="javascript" type="text/javascript">
var counterx = 2;
var counter = 2;

$(document).ready(function(){
 $("#addMoreRcpt").click(function(){
		 if(counterx>10){
					alert("Only 10 reciepients are allowed");
					return false;
		 }

		 var newTextBoxDiv = $(document.createElement('div')).attr("id", 'RcptEml_' + counter);
		 newTextBoxDiv.css('padding','2px');
		 newTextBoxDiv.css('margin','2px');

		 newTextBoxDiv.append('<label>Name: <input type="text" name="txtRcptName_'+ counter + '" id="txtRcptName_'+ counter + '" size="20" maxlength="50" align="absmiddle" />  Email: <input type="text" size="40" name="txtRcptEmail_'+ counter + '" id="txtRcptEmail_'+ counter + '" maxlength="50" align="absmiddle" /></label><a id="delRcpt_'+ counter + '" href="javascript:fncDelRcpt('+ counter + ')">Remove Receipient</a>');

		 newTextBoxDiv.appendTo("#RcptGroup");
		 counter++;
		 counterx++;
	});
});

function fncDelRcpt(id){
	$("#RcptEml_"+id).remove();
	counterx--;
}
</script>
</head>

<body>
<div id="RcptGroup">
              		<div id="RcptEml_1" style="padding:2px; margin: 2px;">
                    	<label>Name: <input type="text" name="txtRcptName_1" id="txtRcptName_1" size="20" maxlength="50" align="absmiddle" />  Email: <input type="text" size="40" name="txtRcptEmail_1" id="txtRcptEmail_1" maxlength="50" align="absmiddle" /></label>
                    </div>
                	</div>
				<br /><a id="addMoreRcpt" href="#" >Add more reciepients</a>
</body>
</html>