<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.5/dist/flowbite.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />

  @vite('resources/css/app.css')

  <link rel="stylesheet" href="{{asset("style.css")}}"  />  

  <title>Recrutement</title>
</head>
<body>


    @if (session('duplicate')) 
    <div id="confirmationModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
            <div class="p-6">
                <div class="flex items-center mb-6">
                    <div class="bg-red-100 rounded-full p-2 mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                        </svg>
                          
                    </div>
                    <h2 class="text-xl font-semibold">Doublon</h2>
                </div>
                <div class="mb-4 ml-10">
                    <p>Un contact existe déja avec le meme prénom et le meme nom</p>
                    <p>Etes-vous sur de vouloir ajouter ce contact ?</p>
                </div>
            </div>
            <div class="bg-gray-100 p-4 mt-4  rounded-b-lg flex justify-end space-x-4 text-sm">
                <button id="cancelBtn" type="button"  class="px-4 py-1.5 bg-white text-black border border-gray-400 rounded" >Annuler</button>
                <button id="confirmBtn" type="submit"  class="px-4 py-1.5 bg-red-500 text-white  border border-black rounded">Confimer</button> </div>
        </div>
    </div> 
    @endif



<!-- component -->
<body class="antialiased font-sans bg-gray-200">
  <div class="container mx-auto px-4 sm:px-8">
      <div class="py-8">
          <div class="mb-2">
              <h2 class="text-2xl font-semibold leading-tight">Listes des Contacts</h2>
          </div>
    
          @if ($errors->any())
              <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 w-1/2" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Danger</span>
                <div>
                  <span class="font-medium">Errors</span>
                    <ul class="mt-1.5 list-disc list-inside">
                      @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                  </ul>
                </div>
              </div>
        @endif
        @if (session('status'))
            <div id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 w-1/2" role="alert">
                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div class="ms-3 text-sm font-medium">
                    {{ session('status') }}
                </div>
                <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 " data-dismiss-target="#alert-3" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                </button>
            </div>
        @endif

          <div class="flex mt-4 mb-2 justify-between">
            <input placeholder="Recherche..."  id="search-input" name="value" value="{{$_GET['value'] ?? ""}}" type="text" class="focus:outline-none w-96 bg-white focus:ring-2 font-medium rounded-lg text-sm px-4 py-1.5 me-2 mb-2 focus:ring-gray-300 bg-white">    
            <button data-modal-target="add-modal" data-modal-toggle="add-modal"  type="button" class="focus:outline-none text-white bg-gray-500 hover:bg-gray-600 focus:ring-1 focus:ring-gray-600 font-medium rounded-lg text-sm pl-2 pr-4 py-1.5 me-2 mb-2  hover:bg-gray-700 focus:ring-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 inline ">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>                  
                Ajouter
                </button>           
          </div>


          
         
          <div class="-mx-4 sm:-mx-8 px-4 sm:px-8  overflow-x-auto">
              <div class="inline-block min-w-full shadow0 rounded-lg overflow-hidden">
                  <table class="min-w-full leading-normal" id="data-table">
                      <thead>
                          <tr>
                              <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"> 
                                  <div class="flex items-center"> 
                                    NOM DU CONTACT
                                 </div>
                              </th>
                              <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">        
                                  <div class="flex items-center"> 
                                    SOCIÉTÉ
                                 </div>
                              </th>
                              <th class="no-search px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <div class="flex items-center"> 
                                   STATUT
                                </div>
                                </th>
                              <th class="no-sort px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                  
                              </th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach ($contacts as $contact)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                              <p class="text-gray-900 whitespace-no-wrap">{{$contact->prenom}} {{$contact->nom}}</p>
                            </td>
                              <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                  <p class="text-gray-900 whitespace-no-wrap">{{$contact->organ ? $contact->organ->nom : ""}}</p>
                              </td>
                              <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                @if(isset($contact->organ))
                                    @if ($contact->organ->statut == "LEAD")
                                        <span class="relative inline-block px-3 py-1 font-semibold text-blue-900 leading-tight">
                                            <span aria-hidden class="absolute inset-0 bg-blue-200 opacity-50 rounded-full "></span>
                                            <span class="relative">Lead</span>
                                        </span>
                                    @endif
                                    @if ($contact->organ->statut == "PROSPECT")
                                        <span class="relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                                            <span aria-hidden class="absolute inset-0 bg-red-200 opacity-50 rounded-full "></span>
                                            <span class="relative">Prospect</span>
                                        </span>
                                    @endif
                                    @if ($contact->organ->statut == "CLIENT")
                                        <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                            <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full "></span>
                                            <span class="relative">Client</span>
                                        </span>
                                    @endif
                                @endif


                              </td>
                              <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                               
                                <ul class="flex space-x-2">
                                    <li>
                                        <a href="#" data-modal-target="view-modal" data-modal-toggle="view-modal" data-id="{{ $contact->id }}" class="text-gray-500 hover:text-gray-600 view_modal">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                              </svg>
                                                   
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" data-id="{{ $contact->id }}" data-modal-target="edit-modal" data-modal-toggle="edit-modal" class="text-gray-500 hover:text-gray-600 edit_contact">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                            </svg>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" data-id="{{ $contact->id }}"  class="text-gray-500 hover:text-gray-600 delete_contact">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                              </svg>   
                                        </a>
                                    </li>
                                
                                </ul>
                            


                              </td>
                          </tr>
                        @endforeach
                      </tbody>
                  </table>
              </div>
          </div>

          {{-- {{$contacts->links('vendor.pagination.tailwind')}} --}}


      </div>
  </div>





{{--************** Modals **************--}}

<!--Add Contact Modal -->
<div id="add-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
        <h2 class="text-xl font-semibold mb-5">Ajouter un Contact</h2>
        <form id="infoForm" class="space-y-3" method="POST" action="{{route('contact.store')}}">
            @csrf

            @if (session('duplicate')) <input type="hidden" name="confirm" value="true"> @endif

            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label for="prenom" class="block text-sm text-gray-700">Prénom</label>
                    <input type="text" id="prenom" name="prenom" value="{{old('prenom')}}" class="mt-1 block w-full px-3 py-2 border rounded-md" required>
                </div>
                <div>
                    <label for="nom" class=" text-sm block text-gray-700">Nom</label>
                    <input type="text" id="nom" name="nom" value="{{old('nom')}}" class="mt-1 block w-full px-3 py-2 border rounded-md" required>
                </div>
            </div>
            <div>
                <label for="e_mail" class="text-sm block text-gray-700">Email</label>
                <input type="email" id="e_mail" name="e_mail" value="{{old('e_mail')}}" class="mt-1 block w-full px-3 py-2 border rounded-md" required>
            </div>
            <div>
                <label for="orgnom" class="text-sm block text-gray-700">Entreprise</label>
                <input type="text" id="orgnom" name="orgnom" value="{{old('orgnom')}}" class="mt-1 block w-full px-3 py-2 border rounded-md" required>
            </div>
            <div>
                <label for="orgadresse" class="text-sm block text-gray-700">Address</label>
                <textarea id="orgadresse" name="orgadresse" rows="2" class="mt-1 block w-full px-3 py-2 border rounded-md">{{old('orgadresse')}}</textarea>
            </div>
            <div class="flex flex-row">
                <div class="basis-1/3 mr-2">
                    <div>
                        <label for="orgcode_postal" class="text-sm block text-gray-700">Code postal</label>
                        <input type="text" id="orgcode_postal" value="{{old('orgcode_postal')}}" name="orgcode_postal" class="mt-1 block w-full px-3 py-2 border rounded-md" required>
                    </div>
                </div>
            
                <div class="basis-2/3">
                    <div>
                        <label for="orgville" class="text-sm block text-gray-700">Ville</label>
                        <input type="text" id="orgville" value="{{old('orgville')}}" name="orgville" class="mt-1 block w-full px-3 py-2 border rounded-md" required>
                    </div>
                </div>
            </div>
            <div class="flex flex-row">
                <div class="basis-2/4">
                    <div>
                        <label for="orgstatut" class="text-sm block text-gray-700">Staut</label>

                        <select id="orgstatut" name="orgstatut" value="{{old('orgstatut')}}" class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">

                            <option selected value="LEAD">Lead</option>
                            <option value="CLIENT">Client</option>
                            <option value="PROSPECT">Prospect</option>
                        </select>

                    </div>
                </div>
            </div>


            <div class="flex justify-end space-x-4 text-sm">
                <button type="button"  class="px-3 py-2 bg-white text-black border border-gray-400 rounded"  data-modal-toggle="add-modal">Annuler</button>
                <button type="submit"  class="px-3 py-2 bg-gray-500 text-white  border border-black rounded">Valider</button>
            </div>
        
        </form>
        
    </div>
</div> 


<!--Edit Contact Modal -->
<div id="edit-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
        <h2 class="text-xl font-semibold mb-5">Modifier un Contact</h2>
        <form id="infoFormEdit" class="space-y-3" method="POST" action="">
            @csrf
            @method('put')
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label for="eprenom" class="block text-sm text-gray-700">Prénom</label>
                    <input type="text" id="eprenom" name="prenom" class="mt-1 block w-full px-3 py-2 border rounded-md" required>
                </div>
                <div>
                    <label for="enom" class=" text-sm block text-gray-700">Nom</label>
                    <input type="text" id="enom" name="nom" class="mt-1 block w-full px-3 py-2 border rounded-md" required>
                </div>
            </div>
            <div>
                <label for="ee_mail" class="text-sm block text-gray-700">Email</label>
                <input type="email" id="ee_mail" name="e_mail" class="mt-1 block w-full px-3 py-2 border rounded-md" required>
            </div>
            <div>
                <label for="eorgnom" class="text-sm block text-gray-700">Entreprise</label>
                <input type="text" id="eorgnom" name="orgnom" class="mt-1 block w-full px-3 py-2 border rounded-md" required>
            </div>
            <div>
                <label for="eorgadresse" class="text-sm block text-gray-700">Address</label>
                <textarea id="eorgadresse" name="orgadresse" rows="2" class="mt-1 block w-full px-3 py-2 border rounded-md"></textarea>
            </div>
            <div class="flex flex-row">
                <div class="basis-1/3 mr-2">
                    <div>
                        <label for="eorgcode_postal" class="text-sm block text-gray-700">Code postal</label>
                        <input type="text" id="eorgcode_postal" name="orgcode_postal" class="mt-1 block w-full px-3 py-2 border rounded-md" required>
                    </div>
                </div>
            
                <div class="basis-2/3">
                    <div>
                        <label for="eorgville" class="text-sm block text-gray-700">Ville</label>
                        <input type="text" id="eorgville" name="orgville" class="mt-1 block w-full px-3 py-2 border rounded-md" required>
                    </div>
                </div>
            </div>
            <div class="flex flex-row">
                <div class="basis-2/4">
                    <div>
                        <label for="eorgstatut" class="text-sm block text-gray-700">Staut</label>

                        <select id="eorgstatut" name="orgstatut" class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">

                            <option selected value="LEAD">Lead</option>
                            <option value="CLIENT">Client</option>
                            <option value="PROSPECT">Prospect</option>
                        </select>

                    </div>
                </div>
            </div>


            <div class="flex justify-end space-x-4 text-sm">
                <button type="button" id="annuler_edit"  class="px-3 py-2 bg-white text-black border border-gray-400 rounded"  data-modal-toggle="edit-modal">Annuler</button>
                <button type="submit"  class="px-3 py-2 bg-gray-500 text-white  border border-black rounded">Valider</button>
            </div>
        
        </form>
        
    </div>
</div> 


<!--View Contact Modal -->
<div id="view-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
        <h2 class="text-xl font-semibold mb-5">Détail d'un contact</h2>
        <form id="infoFormView" class="space-y-3"  action="">
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label for="vprenom" class="block text-sm text-gray-700">Prénom</label>
                    <input type="text" id="vprenom" name="prenom" class="mt-1 block w-full px-3 py-2 border rounded-md" disabled>
                </div>
                <div>
                    <label for="vnom" class=" text-sm block text-gray-700">Nom</label>
                    <input type="text" id="vnom" name="nom" class="mt-1 block w-full px-3 py-2 border rounded-md" disabled>
                </div>
            </div>
            <div>
                <label for="ve_mail" class="text-sm block text-gray-700">Email</label>
                <input type="email" id="ve_mail" name="e_mail" class="mt-1 block w-full px-3 py-2 border rounded-md" disabled>
            </div>
            <div>
                <label for="vorgnom" class="text-sm block text-gray-700">Entreprise</label>
                <input type="text" id="vorgnom" name="orgnom" class="mt-1 block w-full px-3 py-2 border rounded-md" disabled>
            </div>
            <div>
                <label for="vorgadresse" class="text-sm block text-gray-700">Address</label>
                <textarea id="vorgadresse" name="orgadresse" rows="2" class="mt-1 block w-full px-3 py-2 border rounded-md" disabled></textarea>
            </div>
            <div class="flex flex-row">
                <div class="basis-1/3 mr-2">
                    <div>
                        <label for="vorgcode_postal" class="text-sm block text-gray-700">Code postal</label>
                        <input type="text" id="vorgcode_postal" name="orgcode_postal" class="mt-1 block w-full px-3 py-2 border rounded-md" disabled>
                    </div>
                </div>
            
                <div class="basis-2/3">
                    <div>
                        <label for="vorgville" class="text-sm block text-gray-700">Ville</label>
                        <input type="text" id="vorgville" name="orgville" class="mt-1 block w-full px-3 py-2 border rounded-md" disabled>
                    </div>
                </div>
            </div>
            <div class="flex flex-row">
                <div class="basis-2/4">
                    <div>
                        <label for="vorgstatut" class="text-sm block text-gray-700">Staut</label>

                        <select id="vorgstatut" name="orgstatut" class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" disabled>

                            <option selected value="LEAD">Lead</option>
                            <option value="CLIENT">Client</option>
                            <option value="PROSPECT">Prospect</option>
                        </select>

                    </div>
                </div>
            </div>


            <div class="flex justify-end space-x-4 text-sm">
                <button type="button" id='annuler'  class="px-3 py-2 bg-white text-black border border-gray-400 rounded"  data-modal-toggle="view-modal">Annuler</button>
            </div>
        
        </form>
        
    </div>
</div> 


<!--Delete Contact Modal -->
<div id="delete-modal"  tabindex="-1" data-modal-placement="top-center" aria-hidden="true" class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
        <div class="p-6">
            <div class="flex items-center mb-6">
                <div class="bg-red-100 rounded-full p-2 mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                    </svg>
                      
                </div>
                <h2 class="text-xl font-semibold">Supprimer le contact</h2>
            </div>
            <div class="mb-4 ml-10">
                <p>Etes-vous sur de vouloir supprimer le contact ?</p>
                <p>Cette opération est irreversible.</p>
            </div>
        </div>
        <div class="bg-gray-100 p-4 mt-4  rounded-b-lg flex justify-end space-x-4 text-sm">
            <button type="button" id="annuler_dele"  class="px-4 py-1.5 bg-white text-black border border-gray-400 rounded"  data-modal-toggle="delete-modal">Annuler</button>
            <form method="post" action="{{route('contact.destroy')}}">
                @csrf
                @method('delete')
                <input type="hidden" name="contactid" id="contactid">
                <button type="submit"  class="px-4 py-1.5 bg-red-500 text-white  border border-black rounded">Confimer</button>

            </form>
        </div>
    </div>
</div> 


  
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script> 
<script src="https://unpkg.com/flowbite@1.5.5/dist/flowbite.js"></script>

<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>

<script src="{{asset("script.js")}}"></script>  

</body>
</html>