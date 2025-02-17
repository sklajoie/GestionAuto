@extends('layouts.master')
@section('content')

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper ">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>VERSEMENTS</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('Accueil')}}">ACCUEIL</a></li>
              <li class="breadcrumb-item active">Versements</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            
            @if ($message = Session::get('success'))
                        <div class="alert alert-success  alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">×</button>  
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif

            <div class="card">
              <div class="card-header" style="text-align:center; !important">
                <h3 class="card-title " >LISTE DES VERSEMENTS</h3>
                <button type="button" class="btn btn-sm btn-primary" style="margin-left : 10px" data-toggle="modal" data-target="#addModal">
                  AJOUTER <i class="fa fa-plus"></i>
                 </button>
              </div>
              <!-- /.card-header -->
              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th></th>
                    <th>Date</th>
                    <th>Code Paiement</th>
                    <th>Montant</th>
                    <th>Rubrique</th>
                    <th>Moyen</th>
                    <th>Bénéficiaire</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($versements as $key=>$versement )
                  <tr>
                    <td>{{++$key}}</td>
                    <td>{{$versement->date}}</td>
                    <td>{{$versement->codePaiement}}</td>
                    <td>{{$versement->Montant}}</td>
                    <td>{{$versement->Rubrique}}</td>
                    <td>{{$versement->MoyenPaiemet}}</td>
                    <td>
                      @if($versement->Type =="autre")
                      {{$versement->Beneficier}} 
                      @endif
                      @if($versement->Type == "employe")
                      {{$versement->conducteur ? $versement->conducteur->NomPrenom : ""}} ({{$versement->conducteur ? $versement->conducteur->Contact : ""}})
                      @endif

                    </td>
                    <td>
                      <div  style="display:flex; flex-direction:row; ">
                      <a href="{{route('Versements.edit', $versement->id)}}" class="btn btn-success btn-xs m-1"> <i class="fa fa-edit"></i></a>
                      <a href="javascript:;" class="btn btn-xs btn-danger sa-delete m-1" data-form-id="category-delete-{{$versement->id}}">
                        <i class="fa fa-trash"></i>
                    </a> 

                    <form id="category-delete-{{$versement->id}}" action="{{route('Versements.destroy', $versement->id)}}" method="POST"> 
                    @csrf 
                    @method('DELETE') 

                    </form>
                      </div>
                    </td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->

      <div class="modal fade " id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">GESTION CAISSE</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
               <form action="{{route('Versements.store')}}" enctype="multipart/form-data" method="POST">
                    @csrf
                 
                  <div class="row">
      
                      <div class="col-md-4" id="clikmembrebeni">
                          <label for="checkin">Type</label>
                          <div class="">
                           <select class="form-control type_benef" required name="type_benef" id="type_benef" >
                            <option value="">Type</option>
                            <option value="employe">Employe</option>
                            <option value="autre">Autre</option>
                           </select>
                          </div>
                      </div>
                     
                      <div class="col-md-4" id="voirmembrebenif">
                          <label for="checkin">Beneficiaire/Provenance</label>
                          <div class="Type_benefificiaire" id="Type_benefificiaire" >
                           {{-- <input type="text" id="beneficiare" name="beneficiare" required class="form-control"> --}}
                                  <select class="form-control select2" name="beneficiare" id="beneficiare">
                                  <option value="">Ajouter Beneficiaire/Provenance</option>
                                  
                                  </select>
                           
                          </div>
                      </div>
                      <div class="col-md-4" id="">
                          <label for="checkin">Véhicule</label>
                          <div class="" id="" >
                           {{-- <input type="text" id="beneficiare" name="beneficiare" required class="form-control"> --}}
                                  <select class="form-control select2" name="idvehicule" id="idvehicule">
                                  <option value="">Véhicule</option>
                                  @foreach ( $voitures as $voiture )
                                  <option value="{{$voiture->id}}">{{$voiture->Matriculation}} {{$voiture->Marque}} ({{$voiture->Model}})</option>
                                  @endforeach
                                  </select>
                           
                          </div>
                      </div>
                      <div class="col-md-3">
                          <label for="checkin">Type mouvement</label>
                          <div class="">
                              <select type="text" id="type_mouvement" name="type_mouvement" required
                                  class="form-control type_mouvement">
                                  <option  value="">Type de mouvement</option>
                                  <option value="SORTIE DE CAISSE">SORTIE DE CAISSE</option>
                                  <option value="ENTREE EN CAISSE">ENTREE EN CAISSE</option>
                              </select>
                          </div>
                      </div>
                      
                     
                      <div class="col-md-3">
                        <label for="checkin">Rubrique Mouvement</label>
                        <div class="naturemvmt">
                           <select type="text" id="naturemvmt" name="nature_mouvement" required class="form-control naturemvmt">
                            <option value="">Ajouter Nature</option>
                            </select>
                        </div>
                        </div>
                        <div class="col-md-3">
                           
                          <label for="checkin">Montant Mouvement</label>
                          <div class="">
                              <input type="number" id="montant" name="montant"
                                  required class="form-control">
                          </div>
                      </div>
                      <div class="col-md-3">
                          <label for="checkin">Date Mouvement</label>
                          <div class="">
                              <input type="date" id="date" name="date" value="{{date('Y-m-d')}}"
                                  class="form-control">
                          </div>
                      </div>
                      <div class="col-md-12">
                          <table style="width:100%;">
                              <tr>
      
                                  {{-- <td style="background-color:#00688f;color:#fff;width:15%;"><label
                                          class="checkbox-inline on"><input type="radio" id="prelevement" onclick="prelevement()" name="paiement"
                                              value="1 PRELEVEMENT">1 PRELEVEMENT</label></td> --}}
      
                                  <td style="background-color:#00688f;color:#fff;width:15%;"><label
                                          class="checkbox-inline on"><input type="radio" id="cash" onclick="cash()" name="paiement"
                                              value="ESPECE">ESPECE</label></td>
                                              
                                  <td style="background-color:#00688f;color:#fff;width:15%;"><label
                                          class="checkbox-inline on "><input type="radio" onclick="virement()" id="virement" name="paiement"
                                              value="VIREMENT" >VIREMENT</label></td>
                                  <td style="background-color:#00688f;color:#fff;width:15%;"><label
                                          class="checkbox-inline on cheque"><input type="radio" onclick="cheque()" class="cheque" id="cheque" name="paiement"
                                              value="CHEQUE" >CH&Egrave;QUE</label></td>
                                  <td style="background-color:#00688f;color:#fff;width:15%;"><label
                                          class="checkbox-inline on"><input type="radio" onclick="carte()" id="carte" name="paiement"
                                              value="MOBILE MONEY">MOBILE MONEY</label></td>
      
                              </tr><br> 
                          </table><br>
                      </div>
                          <div class="col-md-6" id="nummobile">
                      <label for="checkin" >Numéro Mobile (MOBILE MONEY)</label>
                          <div class="">
                              <input type="text"  name="nummobile"
                                  class="form-control">
                          </div>
                      </div>
                          <div class="col-md-6" id="banque">
                      <label for="checkin" id="banque">Banque</label>
                          <div class="">
                              <input type="text"  name="banque"
                                  class="form-control">
                          </div>
                      </div>
                      <div class="col-md-6" id="numcheque">
                      <label for="checkin" >Numéro Virement/Ch&egrave;que</label>
                          <div class="">
                              <input type="text"  name="cheque" 
                                  class="form-control">
                          </div>
                      </div>
                      <div class="col-md-6">
                          <label for="checkin">Pièce Justificatif
                            <span style="color:red">
                              Veuillez fusionnez les documents si vous avez plus de 2 pièces à joindre
                            </span>
                          </label>
                          <div class="">
                              <input type="file" id="decharge" name="decharge"
                                  class="form-control">
                          </div>
                          
                      </div>
                      
                      <div class="col-md-6">
                          <label for="checkin">Ajouter plus de détails</label>
                          <div class="">
                              <textarea name="commentaire" class="form-control" id="commentairetest"></textarea><br>
                          </div>
                      </div>
                      
                      <div class="col-md-8"></div>
      
                      <div class="col-md-6">
                          <button class="btn btn-success btn-block" style="background:#252b38;"
                              onClick="javascript:window.location.reload()">Annuler</button>
                      </div>
                      <div class="col-md-6">
                          <button class="btn btn-success btn-block" style="background:#252b38;" id="valider" type="submit">Valider</button>
                      </div>
      
                  </div>
      
              </form>
            </div>
            {{-- <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Send message</button>
            </div> --}}
          </div>
        </div>
      </div>

    </section>
    <!-- /.content -->
  </div>

@endsection