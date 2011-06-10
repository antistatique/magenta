$(document).ready(function() {
  
  
  //Messages
  $('#message.actived').livequery(function(){
    display_message();  
  });

  
  function display_message(){
    // console.log("message displayed");
    $('#message').hide().fadeIn('slow').click(function(e) {
      $(this).fadeOut('slow', function(e) {
          $(this).slideUp("slow").html('').removeClass('actived');
        });
    });    
  }
  
  //form check http to url fields
  // #contact_url
  $('#contact_url, #company_url').livequery(function(){
    $(this).blur(function(){
      var fieldvalue = $(this).attr('value');
      if(!isUrl(fieldvalue)&&fieldvalue!=''&&fieldvalue!='http://'){
        $(this).val('http://'+fieldvalue);
      }
    });
  });
  
  function isUrl(s) {
  	var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
  	return regexp.test(s);
  }
  
  //form required fields
  $('.required_field').livequery(function(e){
    var label = $(this).parent('li').children('label');
    var contenu = label.text();
    var star = '<span class="required_star">*</span>';
    label.html(contenu + star);
  });
  
  //markdown ...
  $('.markdownbloc_edit').livequery(function(e){
    $('.markdownbloc_edit').markItUp(myMarkdownSettings);
  });
  //largeTypeAction
  $(".largeTypeAction").livequery(function(e){
    $(this).click(function(e) {
      $("body").append(
      $('<div>').attr('id', 'largeTypeAction').html($('<span>').text($(this).text())).corner("30px").fadeIn("fast").one('click',
      function() {
        $(this).remove();
      }));
    });
  })
  
  //Module contact, display infos for companies
  $(".contact_item").livequery(function(e){
    $(this).click(function(e) {
      var link = $(this).children(".liste1c").children("a").attr("href");
      var id = $(this).attr("contact_id");
      displayCompany(link, id);
    });      
  });
  $(".contact_item_link").livequery(function(e){
    $(this).click(function(e) {
     var link = $(this).attr("href");
     var id = $(this).attr("contact_id");
     displayCompany(link, id);
      return false;
    });    
  });
  
  $('.contact_item:selected').each(function(){
    displayCompanyProjects($(this).attr('contact_id'));
  });
  
  // Module project, display workflow details
  $(".workflow_item").livequery(function(e){
    $(this).click(function(e) {
     var id = $(this).attr("workflow_id");
     displayWorkflowDetails(id);
    });    
  });

  
  $("#ajouter_workflow").livequery(function(e){
    $(this).click(function(e) {
     var url = $(this).attr("href");
     var urlsplited = url.split('/');
     var id = urlsplited[urlsplited.length -1];  
        //requete ajax            
        $.ajax(
        {
         type: "GET",
         url: url,
         data: "",
         success: function(response)
         { 
           $('#detail').html(response);
         },
         error: function (XMLHttpRequest, textStatus, errorThrown)
         {
           $('#message').html('<h2>Erreur avec la requête</h2>').addClass('actived error');
         } 
        });
      window.location.hash = 'top';        
      return false;        
    });    
  });
  
  $(".modifier_workflow").livequery(function(e){
    $(this).click(function(e) {
     var url = $(this).attr("href");
     var urlsplited = url.split('/');
     var id = urlsplited[urlsplited.length -1];  

     if(!$('#detail').length > 0){
         document.location.href = url;
     }

        //requete ajax            
        $.ajax(
        {
         type: "GET",
         url: url,
         data: "",
         success: function(response)
         { 
           $('#detail').html(response);
         },
         error: function (XMLHttpRequest, textStatus, errorThrown)
         {
           $('#message').html('<h2>Erreur avec la requête</h2>').addClass('actived error');
         } 
        });
    
     

        
      return false;        
    });    
  });
  
  //ajoute un function employee project au formulaire
  $('#add_employee_project').livequery('click', function(e){
    $.ajax({
      type: "GET",
      url: '/project/addAjaxProjectEmployee?new='+(new Date()).getTime(),
      data: "",
      success: function(response){ 
        $(response).insertAfter('ul.project_employee_list li:last-child');
      }
    });
    
    return false;
  });
  
  //switch pour afficher le formulaire "Quick status project change"
  $("#modifier_projet_status").livequery('click', function(e){
     $(this).hide();
     $("#action_quick_status_project_change").show();
     
     e.preventDefault();
  });
  
  

  
  
  //modifie bouton form plus joli
  $('.bt_submit').livequery(function(e){
    var type = $(this).attr('id');
    var val = $(this).attr('value');
    var formsend = $(this).attr('name');    
    $(this).parent().html('<a href="javascript:void(0);" class="detailmenuitem '+type+'" id="modifier_project_form">'+val+'</a>').click(function(){
      $('form#'+formsend).submit();
    });
  });
  
  //affiche le mandat lorsqu'on clique sur la ligne entière
  $('.mandat_item').livequery(function(e){
      $(this).click(function(e){
      var link = $(this).find('a.show_project').attr('href');
      document.location.href = link;
      return true;
    });
  });  
  $('#detail_project').livequery(function(e){
    $(this).click(function(e) {
      var url = $(this).attr("href");
      $("#detailcontent_p").slideUp('fast');
      //@todo replace by ajax function
       $("#detail").load(url,
       function() {
         $("#detail").slideDown('fast');
       });
       return false;
    })
  });

  $('#modifier_project').livequery(function(e){
    $(this).click(function(e) {
      var url = $(this).attr("href");
      $("#detailcontent_p").slideUp('fast');
      //@todo replace by ajax function
       $("#detail").load(url,
       function() {
         $("#detail").slideDown('fast');
       });
       return false;
    })
  });



 // $("#edit_project").livequery(function(e){
 //  $('#edit_project').submit(function() {
 //    console.log('submitting...');
 // 
 //     
 //    var options = { 
 //           target:        '#detail',   // target element(s) to be updated with server response 
 //           success:       showResponse,  // post-submit callback
 //           error:         showResponseError
 //           };
 // 
 //           
 //    $(this).ajaxSubmit(options); 
 // 
 //    // always return false to prevent standard browser submit and page navigation 
 //    return false;              
 //   }); 
 // }); 
 // 
 // function showResponseError(event, XMLHttpRequest, ajaxOptions, thrownError)  {
 //    alert('error');
 //    alert(XMLHttpRequest.responseText);
 //    $('#detail').fadeIn('slow').html(XMLHttpRequest.responseXML);      
 //    $('#message').html('<h2>Erreur avec la requête</h2>').addClass('actived error');     
 // }  
 // function showResponse(responseText, statusText)  {   
 //     $('#detail').fadeIn('slow').html(responseText);
 //     $('#message').html('<h2>Mise à jour réalisée avec succès</h2>').addClass('actived success');             
 //  }
  
  
  $(".modifier_tache").livequery(function(e){
    $(this).click(function(e) {
     var url = $(this).attr("href");
     var urlsplited = url.split('/');
     var id = urlsplited[urlsplited.length -1];  
                
       $.ajax(
       {
         type: "GET",
         url: url + ' #workflow_item_'+id,
         data: "id=" + id,
         success: function(response)
         { 
           // extact the part of the list concerning the current workflow
           var response_part = $(response).find('#workflow_item_'+id).html();
           $('#workflow_item_'+id).html(response_part);
           $('#message').html('<h2>Workflow mis à jour avec succès</h2>').addClass('actived success');
         },
         error: function (XMLHttpRequest, textStatus, errorThrown)
         {
           $('#message').html('<h2>Erreur avec la requête</h2>').addClass('actived error');
         },
         complete: function()
         {
           displayWorkflowDetails(id);
         }
         
     });

        
      return false;        
    });    
  });
  
  
  
  // signout link
  // first time
  $.fn.wait = function(time, type) {
          time = time || 1000;
          type = type || "fx";
          return this.queue(type, function() {
              var self = this;
              setTimeout(function() {
                  $(self).dequeue();
              }, time);
          });
      };
  if($('#session_bloc').hasClass('just_signed')){
    $('#session_bloc').wait().wait().wait().animate( {top:"-74px"}, 1500 );
  }
  //else
  $('#session_bloc').hover(
    function () {
      $(this).animate( { top:"0px" }, 1500 );
    }, 
    function () {
      $(this).wait().animate( {top:"-74px"}, 1500 );
    }
  );
  
  $('input#project_title').keyup(function(){
    var var_to_slug = $(this).val();
    //var number = $('input#project_number').val();
		var slugcontent = var_to_slug.replace(/[àâä]/g,"a")
                                            .replace(/[éèêë]/g,"e").replace(/[îï]/g,"i")
                                            .replace(/[ôö]/g,"o").replace(/[ùûü]/g,"u")
                                            .replace(/\s/g,'-').replace(/[^a-zA-Z0-9\-]/g,'');
		$('input#project_slug').val(slugcontent.toLowerCase());
    //alert(youpi);
  });
  
  // recherche company auto suggest agax
    $("input.autosuggest").keyup(function()
    {
      if(!$('#liste').hasClass('workflowlist')){
      var search;
      var post = $(this).parents('#searchform').attr('action');
                  
      search = $("#query").val();
      if(search.length>=3||search.length<1){
            $.ajax(
            {
              type: "GET",
              url: post,
              data: "query=" + search,
              success: function(response)
              { 
                $("#liste").empty();
                  if (response.length > 0)
                  $('#message').html('<h2>Erreur avec la requête</h2>').addClass('actived error');
                {             
                  $("#liste").html(response);
                  var rep = $('.nbmandat').text();

                  $('#message').html('<h2>Il y a '+rep+' correspondant à votre recherche</h2>').removeClass('error').addClass('actived info');                    



                }
              }
          });        
      }
    }
        
    });  

  //.btn
  $('.btn').each(function() {
    var b = $(this);
    var tt = b.text() || b.val();

    if ($(this).is(':button,:submit')) {
      b = $('<a>').insertAfter(this).addClass(this.className).attr('id', this.id);
      if ($(this).is(':submit')) {
        // restore click event to submit the form
        var form = b.parents('form');
        b.click(function() {
          form.submit();
        });
      }
      // hide the button submit but keep it in code to keep the enter press key behavior
      $(this).attr('style', "visibility:hidden;position:absolute;left:-4000px;");
    }
    b.text('').css({
      cursor: 'pointer'
    }).prepend('<i></i>').append($('<span>').
    text(tt).append('<i></i><span></span>'));
  });
  
  
  //trac ajax submenu
  $('#trac_menu_item').toggle(
    function () {
      var div = $('<div id="submenu_trac">').hide().load('/trac/subMenu');
      $('#sousmenu ul').hide();
      $('#sousmenu #searchformblock').hide();      
      $('#sousmenu').prepend(div.show());
    }, 
    function () {
      $('#sousmenu #submenu_trac').remove();
      $('#sousmenu ul').show();
      $('#sousmenu #searchformblock').show();      
    }
  );
  
  // dashboard ...
  $('#employee_select>select').change(function(){
    var val = $(this).val();
    var url = $('#employee_select').attr('action');
    document.location.href = url+val;
  });

});

// workflow accordion
  function displayWorkflowDetails(id){
     if(!$("#workflow_item_" + id).attr('selected')){
       $('.workflow_item').removeAttr('selected');
       $(".show_workflow_detail").slideUp('fast');
       $("#workflow_item_" + id).attr('selected', true).children(".show_workflow_detail").slideDown('fast');
       
       // $("#workflow_item_" + id).one("click", function(){
       //   if($("#workflow_item_" + id).attr('selected')){
       //     $(this).removeAttr('selected').children('.show_workflow_detail').slideUp('fast');  
       //   }
       // });
       
     }else{
       $("#workflow_item_" + id).removeAttr('selected').children('.show_workflow_detail').slideUp('fast');  
     }
  }

// contact accordion
 function displayCompanyProjects(id){
    if(!$("#contact_item_" + id).attr('selected')){   
     $('.contact_item').removeAttr('selected');
     $(".show_projects").slideUp('fast');   
     $("#contact_item_" + id).attr('selected', true).children(".show_projects").slideDown('fast');
    }
 }


 // display employee details
  function displayEmployeeDetails(link)
  {
    var urlsplited = link.split('/');
    var id = urlsplited[urlsplited.length -1];

    if($('#detailcontent').attr('employee_id')!=id){   
      $("#detail").fadeOut('fast',
      function() {
          //@todo replace by ajax function
           $("#detail").load(link,
           function() {
             $("#detail").fadeIn('fast');
           });       
      });   
    }   
  }
 
// display company details
 function displayCompanyDetails(link)
 {
   var urlsplited = link.split('/');
   var id = urlsplited[urlsplited.length -1];
   
   if($('#detailcontent').attr('company_id')!=id){   
     $("#detail").fadeOut('fast',
     function() {
         //@todo replace by ajax function
          $("#detail").load(link,
          function() {
            $("#detail").fadeIn('fast');
          });       
     });   
   }   
 }
 
 // display company details and projects
 function displayCompany(link, id){
   displayCompanyDetails(link);
   if(!$("#contact_item_" + id).attr('selected')){
     displayCompanyProjects(id);    
    }
 }
