// JavaScript Document


	 
 
	$(function() {
		$("#reset_discount").click(function() {
			var dataString ='';
			var withholding ='';
			var discount = '';
			var discount1 = '';
			var discount2 = '';
			var discount3 = '';
			var vatexempt = '';
			var supplier_discount ='';
			var employee = '';
			var overall = '';
				var customer = $("#customer_discount").val();
			var customer_category = $("#customer_category").val();
	
			//	$("#flash").show();
				//$("#flash").fadeIn(1).html('<span class="load">Loading..</span>');
				$.ajax({
				type: "POST",
				url: "discount.php?withholding="+withholding+"&discount="+discount+
							"&discount1="+discount1+	"&discount2="+discount2+
								"&discount3="+discount3+	"&vatexempt="+vatexempt+
									"&supplier_discount="+supplier_discount+"&customer="+customer+
										"&employee="+employee+"&overall="+overall+"&customer_category="+customer_category,
				data: dataString,
				cache: true,	 
				success: function(html){
				document.getElementById('barcode_var').value='';
				document.getElementById('quantity_var').value=1;
						
						$('#modal-info').modal('hide');
						$(".alert-danger").hide();
						$(".alert-success").fadeIn(800);
						setTimeout(function(){  location.reload(); }, 500);

					
				}  
			});
		
		//return false;
		});
});




  
 
	$(function() {
		$("#override_button").click(function() {
			var dataString ='';
			var id = $("#edit_id").val();
			var srp = $("#srp_edit").val();
			var quantity = $("#quantity_edit").val();
			var override_price = $("#override_price").val();
			var override_reason = $("#override_reason").val();			
					var customer = $("#customer_discount").val();
			var customer_category = $("#customer_category").val();


			
			//	$("#flash").show();
				//$("#flash").fadeIn(1).html('<span class="load">Loading..</span>');
				$.ajax({
				type: "POST",
				url: "override.php?id="+id+"&srp="+srp+
							"&quantity="+quantity+	"&override_price="+override_price+	"&override_reason="+override_reason+
							"&customer="+customer+"&customer_category="+customer_category,
				data: dataString,
				cache: true,	 
				success: function(html){
			//	$("#show").after(html);
				document.getElementById('barcode_var').value='';
									document.getElementById('quantity_var').value=1;

		//		$("#flash").hide();
					$('#modal-warning').modal('hide');
					$("#divamount").load(location.href + " #divamount"); 
					$("#divtorefresh").load(location.href + " #divtorefresh"); 
					$(".alert-danger").hide();
						$(".alert-success").fadeIn(800);
						$(".alert-success").fadeOut(800);
				//	$("#barcode_var").focus();
				
					setTimeout(function(){  location.reload(); }, 800);

			//	$("#item").focus();
				}  
			});
		
		//return false;
		});
});

	$(function() {
		$("#discount_button").click(function() {
			var dataString ='';
			var withholding = $("#withholding").val();
			var discount = $("#discount_option").val();
			var discount1 = $("#discount1").val();
			var discount2 = $("#discount2").val();
			var discount3 = $("#discount3").val();
			var vatexempt = $("#vatexempt").val();
			var supplier_discount = $("#supplier_discount").val();
			var employee = $("#employee").val();
			var overall = $("#overall").val();
			var customer = $("#customer_discount").val();
			var customer_category = $("#customer_category").val();


			
			//	$("#flash").show();
				//$("#flash").fadeIn(1).html('<span class="load">Loading..</span>');
				$.ajax({
				type: "POST",
				url: "discount.php?withholding="+withholding+"&discount="+discount+
							"&discount1="+discount1+	"&discount2="+discount2+
								"&discount3="+discount3+	"&vatexempt="+vatexempt+
									"&supplier_discount="+supplier_discount+
										"&customer="+customer+"&customer_category="+customer_category+
										"&employee="+employee+"&overall="+overall,
				data: dataString,
				cache: true,	 
				success: function(html){
			//	$("#show").after(html);
				document.getElementById('barcode_var').value='';
									document.getElementById('quantity_var').value=1;

		//		$("#flash").hide();
					$('#modal-info').modal('hide');
					$("#divamount").load(location.href + " #divamount"); 
					$("#divtorefresh").load(location.href + " #divtorefresh"); 
					$(".alert-danger").hide();
						$(".alert-success").fadeIn(800);
						$(".alert-success").fadeOut(800);
					$("#barcode_var").focus();

			//	$("#item").focus();
				}  
			});
		
		//return false;
		});
});

  

	$(function() {
		$(".submit_button").click(function() {
			var textcontent = $("#content").val();
			var quantity = $("#quantity").val();
			var dataString = 'content='+ textcontent;
			if(textcontent=='')
			{
				alert("Enter some text..");
				$("#content").focus();
			}
			else
			{
		
			
				document.getElementById('barcode_var').value=textcontent;
									document.getElementById('quantity_var').value=1;

					$('#modal-default').modal('hide');
					
						$("#divamount").load(location.href + " #divamount");
					$("#divtorefresh").load(location.href + " #divtorefresh"); 
		}
		//return false;
		});
});



$(function() {
		$("#barcode_var").focus(function() {
			
				 
				
		}); 
}); 



$(function() {
		$("#discount_close,#discount_main,#modal-default-btn,#tender_main").focus(function() {
			
				$("#divamount").load(location.href + " #divamount");
					$("#divtorefresh").load(location.href + " #divtorefresh"); 
			
				$("#barcode_var").focus();
				
		}); 
}); 

  