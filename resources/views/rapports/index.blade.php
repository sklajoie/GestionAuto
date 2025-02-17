@extends('layouts.master')
@section('content')

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper ">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>RAPPORTS</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('Accueil')}}">ACCUEIL</a></li>
              <li class="breadcrumb-item active">Rapports</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

  
        <!-- Main content -->
        <section class="content">
          @if ($message = Session::get('success'))
          <div class="alert alert-success  alert-dismissible">
              <button type="button" class="close" data-dismiss="alert">×</button>  
              <strong>{{ $message }}</strong>
          </div>
      @endif
@if ($message = Session::get('danger'))
          <div class="alert alert-danger  alert-dismissible">
              <button type="button" class="close" data-dismiss="alert">×</button>  
              <strong>{{ $message }}</strong>
          </div>
      @endif
          <div class="row">
            <div class="col-md-6">
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">RAPPORT PAR VEHICULE</h3>
    
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <form action="{{route('Rapports-Vehicues')}}" target="blank"  method="GET">
                    {!! csrf_field() !!} 
                    <div class="form-group">
                      <label for="inputStatus">VEHICULES</label>
                      <select id="inputStatus" class="form-control custom-select" name="vehicule">
                        <option value="TOUT">Tout</option>
                        @foreach ($voitures as $voiture )
                        <option value="{{$voiture->id}}">{{$voiture->Matriculation}} {{$voiture->Marque}} {{$voiture->Model}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group row col-12">
                    <div class="col-6">
                      <label>Date Début</label>
                      <input type="date"   class="form-control" id="exampleFirstName" value="{{request()->datedebut}}" name="datedebut" >
                    </div>
                      <div class="col-6">
                        <label>Date Fin</label>
                      <input type="date" class="form-control"  id="exampleInputPassword" name="datefin" value="{{request()->datefin}}">
                    </div>
                      <div class="col-12 form-group" style="text-align: center; margin-top:10px;">
                    <input class="btn btn-primary " type="submit" name="submit"  value="RECHERCHER" />
                  </div>
                  </div>
                    </form>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <div class="col-md-6">
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">RAPPORT PAR EMPLOYE</h3>
    
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <form action="{{route('Rapports-Employer')}}" target="blank"  method="GET">
                    {!! csrf_field() !!} 
                    <div class="form-group">
                      <label for="inputStatus">EMPLOYE</label>
                      <select id="inputStatus" class="form-control custom-select" name="idmembre">
                        <option value="TOUT">Tout</option>
                        @foreach ($membres as $membre )
                        <option value="{{$membre->id}}">{{$membre->NomPrenom}} ({{$membre->Contact}})</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group row col-12">
                    <div class="col-6">
                      <label>Date Début</label>
                      <input type="date"   class="form-control" id="exampleFirstName" value="{{request()->datedebut}}" name="datedebut" >
                    </div>
                      <div class="col-6">
                        <label>Date Fin</label>
                      <input type="date" class="form-control"  id="exampleInputPassword" name="datefin" value="{{request()->datefin}}">
                    </div>
                      <div class="col-12 form-group" style="text-align: center; margin-top:10px;">
                    <input class="btn btn-primary " type="submit" name="submit"  value="RECHERCHER" />
                  </div>
                  </div>
                    </form>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="card card-success">
                <div class="card-header">
                  <h3 class="card-title">RAPPORT PAR MOYENS PAIEMENT</h3>
    
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <form action="{{route('Rapports-Moyens-Paiement')}}" target="blank"  method="GET">
                    {!! csrf_field() !!} 
                    <div class="form-group">
                      <label for="inputStatus">MOYEN</label>
                      <select id="inputStatus" class="form-control custom-select" name="moyensp">
                        <option value="TOUT">Tout</option>
                        @foreach ($moyenpaiements as $moyenpaie)
                        <option value="{{$moyenpaie->MoyenPaiemet}}">{{$moyenpaie->MoyenPaiemet}} </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group row col-12">
                    <div class="col-6">
                      <label>Date Début</label>
                      <input type="date"   class="form-control" id="exampleFirstName" value="{{request()->datedebut}}" name="datedebut" >
                    </div>
                      <div class="col-6">
                        <label>Date Fin</label>
                      <input type="date" class="form-control"  id="exampleInputPassword" name="datefin" value="{{request()->datefin}}">
                    </div>
                      <div class="col-12 form-group" style="text-align: center; margin-top:10px;">
                    <input class="btn btn-success " type="submit" name="submit"  value="RECHERCHER" />
                  </div>
                  </div>
                    </form>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <div class="col-md-6">
              <div class="card card-success">
                <div class="card-header">
                  <h3 class="card-title">RAPPORT PAR RUBRIQUES</h3>
    
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <form action="{{route('Rapports-Rubriques')}}" target="blank"  method="GET">
                    {!! csrf_field() !!} 
                    <div class="form-group">
                      <label for="inputStatus">RUBRIQUE</label>
                      <select id="inputStatus" class="form-control custom-select" name="rubrique">
                        <option value="TOUT">Tout</option>
                        @foreach ($rubriques as $rubrique )
                        <option value="{{$rubrique->Rubrique}}">{{$rubrique->Rubrique}} </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group row col-12">
                    <div class="col-6">
                      <label>Date Début</label>
                      <input type="date"   class="form-control" id="exampleFirstName" value="{{request()->datedebut}}" name="datedebut" >
                    </div>
                      <div class="col-6">
                        <label>Date Fin</label>
                      <input type="date" class="form-control"  id="exampleInputPassword" name="datefin" value="{{request()->datefin}}">
                    </div>
                      <div class="col-12 form-group" style="text-align: center; margin-top:10px;">
                    <input class="btn btn-success " type="submit" name="submit"  value="RECHERCHER" />
                  </div>
                  </div>
                    </form>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">RAPPORT PAR TYPE DE MOUVEMENT</h3>
    
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <form action="{{route('Rapports-Mouvements')}}" target="blank"  method="GET">
                    {!! csrf_field() !!} 
                    <div class="form-group">
                      <label for="inputStatus">TYPE DE MOUVEMENT</label>
                      <select id="inputStatus" class="form-control custom-select" name="mouvement">
                        <option  value="TOUT">Type de mouvement</option>
                        <option value="SORTIE DE CAISSE">SORTIE DE CAISSE</option>
                        <option value="ENTREE EN CAISSE">ENTREE EN CAISSE</option>
                      </select>
                    </div>
                    <div class="form-group row col-12">
                    <div class="col-6">
                      <label>Date Début</label>
                      <input type="date"   class="form-control" id="exampleFirstName" value="{{request()->datedebut}}" name="datedebut" >
                    </div>
                      <div class="col-6">
                        <label>Date Fin</label>
                      <input type="date" class="form-control"  id="exampleInputPassword" name="datefin" value="{{request()->datefin}}">
                    </div>
                      <div class="col-12 form-group" style="text-align: center; margin-top:10px;">
                    <input class="btn btn-info " type="submit" name="submit"  value="RECHERCHER" />
                  </div>
                  </div>
                    </form>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <div class="col-md-6">
              <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">RAPPORT PAR RUBRIQUES</h3>
    
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <form action="{{route('Rapports-Rubriques')}}" target="blank"  method="GET">
                    {!! csrf_field() !!} 
                    <div class="form-group">
                      <label for="inputStatus">RUBRIQUE</label>
                      <select id="inputStatus" class="form-control custom-select" name="rubrique">
                        <option value="TOUT">Tout</option>
                        @foreach ($rubriques as $rubrique )
                        <option value="{{$rubrique->Rubrique}}">{{$rubrique->Rubrique}} </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group row col-12">
                    <div class="col-6">
                      <label>Date Début</label>
                      <input type="date"   class="form-control" id="exampleFirstName" value="{{request()->datedebut}}" name="datedebut" >
                    </div>
                      <div class="col-6">
                        <label>Date Fin</label>
                      <input type="date" class="form-control"  id="exampleInputPassword" name="datefin" value="{{request()->datefin}}">
                    </div>
                      <div class="col-12 form-group" style="text-align: center; margin-top:10px;">
                    <input class="btn btn-info " type="submit" name="submit"  value="RECHERCHER" />
                  </div>
                  </div>
                    </form>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>

        </section>
        <!-- /.content -->

  </div>
  
 
@endsection