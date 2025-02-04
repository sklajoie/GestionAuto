<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{config('app.name')}}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('assets/dist/css/adminlte.min.css')}}">
</head>
<body>
<div class="wrapper" style="margin: 10px">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row" >
      <div class="col-12">
        <h2 class="page-header">
          <i class="fas fa-globe"></i> RAPPORT.
          <small class="float-right">Date: {{date('d-m-Y')}}</small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        {{$vehicule->Type}}
        <address>
          <strong>{{$vehicule->Matriculation}}</strong><br>
          <strong>{{$vehicule->Marque}}</strong><br>
          <strong>{{$vehicule->Model}}</strong><br>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        {{-- To
        <address>
          <strong>John Doe</strong><br>
          795 Folsom Ave, Suite 600<br>
          San Francisco, CA 94107<br>
          Phone: (555) 539-1037<br>
          Email: john.doe@example.com
        </address> --}}
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        {{-- <b>Invoice #007612</b><br>
        <br>
        <b>Order ID:</b> 4F3S8J<br>
        <b>Payment Due:</b> 2/22/2014<br>
        <b>Account:</b> 968-34567 --}}
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-12 table-responsive">
        <h1>ETAT DES VERSEMENTS DU MOIS</h1>
      
           
        <table class="table table-striped">
          <thead>
          <tr>
            <th>MOUVEMENT</th>
            <th>RUBRIQUE</th>
            <th>MOYEN</th>
            <th>MONTANT</th>
            <th>DATE</th>
          </tr>
          </thead>
          <tbody>
            <?php $ttentre=0; $ttsorti=0; ?>
           
            @foreach($dataByMonth as $month => $versements)
          
            <tr>
              <td colspan="2" style="text-align: center; color:red">{{ strftime('%B %Y', strtotime($month . '-01')) }} </td>
             
            <td style="color:green"> ENTRE=>{{$totalByMouvement[$month]}} </td>
            <td style="color:red"> SORTIE=>{{$totalByMouvementstr[$month]}} </td>
            <td colspan="2" style="color:red">TOTAL==>{{$totalByMouvement[$month] - $totalByMouvementstr[$month]}}</td>
            {{-- <td></td>
            <td></td> --}}
          </tr>
          
              @foreach ($versements as $rappor )
              @php 
              if($rappor->Mouvement =="ENTREE EN CAISSE"){ $ttentre += $rappor->Montant;} 
              if($rappor->Mouvement =="SORTIE DE CAISSE"){ $ttsorti += $rappor->Montant;} 
              @endphp
          <tr>
            <td>{{$rappor->Mouvement}}</td>
            <td>{{$rappor->Rubrique}}</td>
            <td>{{$rappor->MoyenPaiemet}}</td>
            <td>{{$rappor->Montant}}</td>
            <td>{{strftime('%d %B %Y', strtotime($rappor->date))}}</td>
          </tr>
          @endforeach
          @endforeach
        </tbody>
      </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-6">
  
      </div>
      <!-- /.col -->
      <div class="col-6">
        <p class="lead">RECAPE TOTAUX</p>

        <div class="table-responsive">
          <table class="table">
            <tr>
              <th style="width:50%">TOTAL DES ENTREES:</th>
              <td>{{$ttentre}} Fcfa</td>
            </tr>
            <tr>
              <th>TOTAL DES SORTIES </th>
              <td>{{$ttsorti}} Fcfa</td>
            </tr>
            {{-- <tr>
              <th>Shipping:</th>
              <td>$5.80</td>
            </tr> --}}
            <tr>
              <th>TOTAL RESTE</th>
              <td>{{$ttentre - $ttsorti}} Fcfa</td>
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
<!-- Page specific script -->

</body>
</html>
