
{{-- Sweet alerte --}}

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
<script>
    $('div.alert').not('.alert-important').delay(3000).fadeOut(350);

 // alerte pour suppression
    $('.sa-delete').on('click', function(){
        let form_id = $(this).data('form-id');
       
      console.log(form_id);
        swal({
                title: "Etre vous sur de supprimer?",
                text: "La suppression d'un element est defitive",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                  $('#'+form_id).submit();
                }
                });
    })

    @if(Session::has('success'))
  		toastr.success("{{ Session::get('success') }}");
  @endif
    </script>

  {{-- password visibilite --}}
<script>
 $(".toggle-password").click(function() {

$(this).toggleClass("fa-eye fa-eye-slash");
var input = $($(this).attr("toggle"));
if (input.attr("type") == "password") {
  input.attr("type", "text");
} else {
  input.attr("type", "password");
}
});

const pwd = document.getElementById("pwd");
const chk = document.getElementById("chk");

chk.onchange = function(e){
  pwd.type = chk.checked ? "text": "password";

}
  // prevent form submit
 
</script>
<script>
 $(".toggle-passwordck").click(function() {

$(this).toggleClass("fa-eye fa-eye-slash");
var input = $($(this).attr("toggle"));
if (input.attr("type") == "password") {
  input.attr("type", "text");
} else {
  input.attr("type", "password");
}
});

const pwdck = document.getElementById("pwdck");
const chkck = document.getElementById("chkck");

chkck.onchange = function(e){
  pwdck.type = chkck.checked ? "text": "password";

}
  // prevent form submit
 
</script>


<script>


    function montants($this) {
        
        var type_mouvement = $('#type_mouvement').val();
        var montant = !parseFloat($this.val()) ? 0 : parseFloat($this.val()) ;
        var caisse = parseFloat(document.getElementById('caisses').value);
        var comptes = parseFloat(document.getElementById('comptes').value);
        

        if (type_mouvement == 0) {
            soldes = (caisse - montant);
            solde = (comptes - montant);
        } else {
            console.log("caisse ",caisse," last ",last," montant ",montant);
            soldes = (caisse + montant);
            solde = (comptes + montant);
        }
        $("#vue_compte").val(Number(solde).toLocaleString());
        $("#compte").val(solde);
        $("#caisse").val(soldes);
        $("#vue_caisse").val(Number(soldes).toLocaleString());

        if (montant == 0 && montant != null && montant != "" && montant != " ") {
            $("#valider").attr("disabled", "disabled");
        } else {
            $("#valider").removeAttr("disabled");
        }
    };

    

 $(".type_benef").change(function() {

        var typebenef = $('#type_benef').val();
      console.log(typebenef);
        var content3 = ""; 

        if (typebenef == "autre") {
           
          content3 =  `<input type="text" id="beneficiare" name="beneficiare" required class="form-control">`;
                

        } else if (typebenef == "employe") {
          content3 = `<select class="form-control" name="beneficiare" id="beneficiare"><option value=""></option>` +
                @foreach ( $membres as $membre )
                `<option value="{{$membre->id}}">{{$membre->NomPrenom}} {{$membre->Contact}} ({{$membre->Reference}})</option>` +
                @endforeach
                `</select>`;
        };



        $("#Type_benefificiaire").html(content3);

    });

</script>

<script>
$(document).ready(function(){
$.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      // Department Change
      $('.type_mouvement').change(function(){

         // Department id
        var type_mouvement = $('#type_mouvement').val();
         // Empty the dropdown
         $('#naturemvmt').find('option').not(':first').remove();
         console.log(type_mouvement);
         // AJAX request 
         $.ajax({
           url: '/recherche-type-mvmt/' + type_mouvement,
           type: 'GET',
           dataType: 'json',
           success: function(response){

             var len = 0;
             if(response['data'] != null){
                len = response['data'].length;
             }
            
             if(len > 0){
                // Read data and create <option >
                for(var i=0; i<len; i++){

                  
                  //  var idnat = response['data'][i].Rubrique;
                   var name = response['data'][i].Rubrique;
                   
                   var option = "<option value='"+name+"'>"+name+"</option>";

                   $("#naturemvmt").append(option); 
                }
             }

           }
         });
      });
      // Department Change
      $('#typemouvement').change(function(){

         // Department id
        var type_mouvement = $('#typemouvement').val();
         // Empty the dropdown
         $('#naturemvtrch').find('option').not(':first').remove();
         console.log(type_mouvement);
         // AJAX request 
         $.ajax({
           url: 'recherche-type-mvmt/'+type_mouvement,
           type: 'get',
           dataType: 'json',
           success: function(response){

             var len = 0;
             if(response['data'] != null){
                len = response['data'].length;
             }
            
             if(len > 0){
                // Read data and create <option >
                for(var i=0; i<len; i++){

                  
                   var idnat = response['data'][i].id;
                   var name = response['data'][i].Nature;
                   
                   var option = "<option value='"+idnat+"'>"+name+"</option>";

                   $("#naturemvtrch").append(option); 
                }
             }

           }
         });
      });

      
      $('#naturemvmt').change(function(){

         // Department id
        var idnature = $('#naturemvmt').val();
         // Empty the dropdown
         $('#rubrique_mouvement').find('option').not(':first').remove();
         console.log(idnature);
         // AJAX request 
         $.ajax({
           url: 'recherche-nature-mvmt/'+idnature,
           type: 'get',
           dataType: 'json',
           success: function(response){

             var len = 0;
             if(response['data'] != null){
                len = response['data'].length;
             }
            
             if(len > 0){
                // Read data and create <option >
                for(var i=0; i<len; i++){

                   var idrub = response['data'][i].id;
                   var name = response['data'][i].Rubrique;
                   
                   var option = "<option value='"+idrub+"'>"+name+"</option>";

                   $("#rubrique_mouvement").append(option); 
                  //  $("#commentairetest").val(name); 
                }
             }

           }
         });
      });
      $('#rubrique_mouvement').change(function(){

         // Department id
        var nomrub = $('#rubrique_mouvement').val();
         // Empty the dropdown
         console.log(nomrub);
      
      });




   });

</script>



<script>
  
$(document).ready(function(){
var voir='rien';
var cheque = $('#cheque').is(":checked");

  $('#banque').hide();
  $('#numcheque').hide();
  $('#nummobile').hide();

  $('#banquep').hide();
  $('#numchequep').hide();
  $('#nummobilep').hide();

  $('#banquepr').hide();
  $('#numchequepr').hide();
  $('#nummobilepr').hide();
  
    $('.banquer').hide();
  $('.numchequer').hide();
  $('.nummobiler').hide();
  
$("#cash").on('click',function(){
     
        $('#nummobile').hide(); // Show with fade effect
        $('#numcheque').hide(); // Show with fade effect
        $('#banque').hide(); // Show with fade effect
});
$("#prelevement").on('click',function(){
     
        $('#nummobile').hide(); // Show with fade effect
        $('#numcheque').hide(); // Show with fade effect
        $('#banque').hide(); // Show with fade effect
});
$("#cheque").on('click',function(){
      console.log('cheque',cheque);
        $('#numcheque').fadeIn(); // Show with fade effect
        $('#banque').fadeIn(); // Show with fade effect
        $('#nummobile').hide();
      });
$("#virement").on('click',function(){
      console.log('cheque',cheque);
        $('#numcheque').fadeIn(); // Show with fade effect
        $('#banque').fadeIn(); // Show with fade effect
        $('#nummobile').hide();
});
$("#carte").on('click',function(){
        $('#nummobile').fadeIn(); // Show with fade effect
        $('#banque').hide(); // Show with fade effect
        $('#numcheque').hide(); // Show with fade effect
});


    $(".modepaiep").on('change',function(){
    
    var moyen=$(".modepaiep").val();
    console.log(moyen);
    
    if (moyen == "3 CHEQUE")
    {
     
         $('#numchequep').fadeIn(); // Show with fade effect
        $('#banquep').show(); // Show with fade effect
        $('#nummobilep').hide();
    }
    else if(moyen == "5 MOBILE MONEY")
    {
     $('#nummobilep').fadeIn(); // Show with fade effect
        $('#banquep').hide(); // Show with fade effect
        $('#numchequep').hide(); // Show with fade effect
    }
    else if(moyen == "4 VIREMENT")
    {
       
  $('#numchequep').fadeIn(); // Show with fade effect
        $('#banquep').fadeIn(); // Show with fade effect
        $('#nummobilep').hide();
    }
    else{
       $('#nummobilep').hide(); // Show with fade effect
        $('#numchequep').hide(); // Show with fade effect
        $('#banquep').hide(); // Show with fade effect
    }

});
     
    $("#modepaier").on('change',function(){
    
    var moyen=$("#modepaier").val();
    console.log("moyen",moyen);
    
    if (moyen == "3 CHEQUE")
    {
     
         $('#numchequer').fadeIn(); // Show with fade effect
        $('#banquer').show(); // Show with fade effect
        $('#nummobiler').hide();
    }
    else if(moyen == "5 MOBILE MONEY")
    {
     $('#nummobiler').fadeIn(); // Show with fade effect
        $('#banquer').hide(); // Show with fade effect
        $('#numchequer').hide(); // Show with fade effect
    }
    else if(moyen == "4 VIREMENT")
    {
       
  $('#numchequer').fadeIn(); // Show with fade effect
        $('#banquer').fadeIn(); // Show with fade effect
        $('#nummobiler').hide();
    }
    else{
       $('#nummobiler').hide(); // Show with fade effect
        $('#numchequer').hide(); // Show with fade effect
        $('#banquer').hide(); // Show with fade effect
    }
});
    $("#modepaiepr").on('change',function(){
    
    var moyen=$("#modepaiepr").val();
    console.log("moyen",moyen);
    
    if (moyen == "3 CHEQUE")
    {
     
         $('#numchequepr').fadeIn(); // Show with fade effect
        $('#banquepr').show(); // Show with fade effect
        $('#nummobilepr').hide();
    }
    else if(moyen == "5 MOBILE MONEY")
    {
     $('#nummobilepr').fadeIn(); // Show with fade effect
        $('#banquepr').hide(); // Show with fade effect
        $('#numchequepr').hide(); // Show with fade effect
    }
    else if(moyen == "4 VIREMENT")
    {
       
  $('#numchequepr').fadeIn(); // Show with fade effect
        $('#banquepr').fadeIn(); // Show with fade effect
        $('#nummobilepr').hide();
    }
    else{
       $('#nummobilepr').hide(); // Show with fade effect
        $('#numchequepr').hide(); // Show with fade effect
        $('#banquepr').hide(); // Show with fade effect
    }
});
 
});

function montantVersement($this) {
        
        var montant_verse = $('#montantVerse').val();
        // var montant = !parseFloat($this.val()) ? 0 : parseFloat($this.val()) ;
        var montantactivite = parseFloat(document.getElementById('montantactivite').value);
        var montantpaye = parseFloat(document.getElementById('montantpaye').value);
        
        var diff = parseFloat(montantpaye) + parseFloat(montant_verse);
        console.log("montant Versement", montant_verse, "montantactic",montantactivite, "montantpaye",montantpaye);  
        console.log(diff);
        $("#enregistre").removeAttr("disabled");
      if(diff > montantactivite){
        $("#enregistre").attr("disabled", "disabled");
        alert("montant est supperieur au reste à payer. Merci de bien verrifier!!!")
      }
      
    };
function mVersementPret($this) {
        
        var montant_verse = $('#montantverse').val();
        // var montant = !parseFloat($this.val()) ? 0 : parseFloat($this.val()) ;
        var montantpret = Number(document.getElementById('montantpret').value);
        var ttrembourse = Number(document.getElementById('ttrembourse').value);
        
        var diff = parseFloat(montant_verse) + parseFloat(ttrembourse);
        console.log("montant Versement", montant_verse, "montantpret",montantpret, "ttrembourse",ttrembourse);  
        let restarembourse = montantpret - diff;
        console.log(diff, restarembourse);
        $("#restapayer").val(restarembourse);
        $("#valider").removeAttr("disabled");

      if(restarembourse < 0){
        $("#valider").attr("disabled", "disabled");
        alert.danger("montant est supperieur au reste à payer. Merci de bien verrifier!!!");
      }
      
    };

</script>

<script >
      var versemencduc =  <?php echo json_encode($versemencduc)  ?>;
      var reparationVehi =  <?php echo json_encode($reparationvehi)  ?>;
    var xValues = ["janvier","fevrier","Mars","Avril","Mai","juin","Juillet","Aout","Septembre","Octobre","Novembre", "Decembre"];
   
   
    new Chart("myChart", {
      type: "bar",
      data: {
        labels: xValues,
        datasets: [{ 
          data: versemencduc,
          borderColor: "blue",
          backgroundColor:"blue",
          label: "VERSEMENT CONDUCTEUR",
          fill: false
        }, 
        // { 
        //   data: [50,150,200,3500],
        //   borderColor: "green",
        //   backgroundColor:"green",
        //   label: "Montant Total Encaissé",
        //   fill: false
          
        // },
         { 
          data: reparationVehi,
          borderColor: "red",
          backgroundColor:"red",
          label: "REPARATION VEHICULE",
          fill: true
        }]
      },
      options: {
        legend: {display: true}
      }
    });
    </script>
<script >
      var qte =  <?php echo json_encode($essencesqte)  ?>;
      var prix =  <?php echo json_encode($essencesprix)  ?>;
      var ttm =  <?php echo json_encode($ttprix)  ?>;
      
      console.log(ttm );
    var xValues = ["janvier","fevrier","Mars","Avril","Mai","juin","Juillet","Aout","Septembre","Octobre","Novembre", "Decembre"];
   
   
    new Chart("myChartEss", {
      type: "line",
      data: {
        labels: xValues,
        datasets: [{ 
          data: qte,
          borderColor: "blue",
          backgroundColor:"blue",
          label: "QTE ESSENCE",
          fill: false
        }, 
        { 
          data: prix,
          borderColor: "red",
          backgroundColor:"red",
          label: "PRIX/L",
          fill: true
          
        },
         { 

          data: ttm,
          borderColor: "green",
          backgroundColor:"green",
          label: "Montant Total",
          fill: false

          
        }]
      },
      options: {
        legend: {display: true}
      }
    });


    $(".anneegf").on('change',function(){
    $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
        var _vm=$(this);
        var _annee=$("#annee").val();
        console.log(_annee);
        var urlanne = "<?php echo url('/Annee-Graphe'); ?>";
        $.ajax({
          
                url: urlanne,
                type: "POST",
                data:{
                    'annee':_annee,
                },
                // dataType:'json',
                success:  function(data){
                location.reload(true);
                        },

            });
  });

    $(".rechvehicule").on('change',function(){
    $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
        var _vm=$(this);
        var _vehicule=$("#vehicule").val();
        console.log(_vehicule);
        var urlvehicule = "<?php echo url('/Vehicule-Graphe'); ?>";
        $.ajax({
          
                url: urlvehicule,
                type: "POST",
                data:{
                    'vehicule':_vehicule,
                },
                // dataType:'json',
                success:  function(data){
                location.reload(true);
                        },

            });
  });

    </script>
  
