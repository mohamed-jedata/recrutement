<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Organisation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $contacts = Contact::all();

        return view('index',['contacts'=>$contacts]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'prenom' => 'required|alpha',
            'nom' => 'required|alpha',
            'e_mail' => 'required|email',
            'orgnom' => 'required|regex:/^[a-zA-Z0-9\s]+$/',
            'orgadresse' => 'required',
            'orgcode_postal' => 'required|numeric',
            'orgville' => 'required',
            'orgstatut' => 'required'
        ],[
            'orgnom.regex' => 'Nom d\'entreprise ne doit contenir que des lettres ou des nombres',
            'orgcode_postal.numeric' => 'Code postal doit etre numérique',
        ]);

        if($validate->fails()){
            return redirect()->back()->with(["errors"=>$validate->errors()]);
        }


          // Check for duplicate contact
          $duplicate = Contact::where('prenom', $request->prenom)
          ->where('nom', $request->nom)
          ->orWhere('nom', $request->nom)
          ->exists();
          if ($duplicate && !$request->has('confirm')) {
            return redirect()
                ->back()
                ->withInput($request->all())
                ->with('duplicate', true);
           }

        $org = new Organisation;
        $org->nom = $request->orgnom;
        $org->adresse = $request->orgadresse;
        $org->code_postal = $request->orgcode_postal;
        $org->ville = $request->orgville;
        $org->statut = $request->orgstatut;
        $org->cle = Str::random();
        $org->save();

        $contact = new Contact;
        $contact->prenom = $request->prenom;
        $contact->nom = $request->nom;
        $contact->e_mail = $request->e_mail;

        $contact->cle = Str::random();
        $contact->telephone_fixe = Str::random();
        $contact->service = Str::random();
        $contact->fonction = Str::random();

        $contact->organisation_id = $org->id;

        $contact->save();
        

        return redirect()->back()->with('status', 'Contact Ajouté!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $contact = Contact::find($id);

        $con = [
            'prenom ' => $contact->prenom,
            'nom ' => $contact->nom,
            'e_mail ' => $contact->e_mail,
            'orgnom ' => $contact->organ->nom,
            'orgadresse ' => $contact->organ->adresse,
            'orgcode_postal ' => $contact->organ->code_postal,
            'orgville ' => $contact->organ->ville,
            'orgstatut ' => $contact->organ->statut,
        ];

        return response()->json($con);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $validate = Validator::make($request->all(),[
            'prenom' => 'required|alpha',
            'nom' => 'required|alpha',
            'e_mail' => 'required|email',
            'orgnom' => 'required',
            'orgadresse' => 'required',
            'orgcode_postal' => 'required|numeric',
            'orgville' => 'required',
            'orgstatut' => 'required'
        ]);

        if($validate->fails()){
            return redirect()->back()->with(["errors"=>$validate->errors()]);
        }

        $contact = Contact::find($id);
        $org = Organisation::find($contact->organ->id) ;
        $org->nom = $request->orgnom;
        $org->adresse = $request->orgadresse;
        $org->code_postal = $request->orgcode_postal;
        $org->ville = $request->orgville;
        $org->statut = $request->orgstatut;
        $org->save();

        $contact->prenom = $request->prenom;
        $contact->nom = $request->nom;
        $contact->e_mail = $request->e_mail;

        $contact->save();
        

        return redirect()->back()->with('status', 'Contact Modofié!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->contactid;
        $organ_id = Contact::find($id)->organ->id;

        Contact::destroy($id);
        Organisation::destroy($organ_id);

        return redirect()->back()->with('status', 'Contact Supprimé!');

    }
}
