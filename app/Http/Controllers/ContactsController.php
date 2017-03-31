<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;

class ContactsController extends Controller
{
    private $limit = 10;
    private $rules = [
            'name' => ['required', 'min:5'],
            'company' => ['required'],
            'email' => ['required' ,'email'],
            'address' => ['required']
    ];

    private $upload_dir = 'public/uploads';

    public function __construct()
    {
        $this->middleware('auth');
        $this->upload_dir = base_path().'/'.$this->upload_dir;
    }

    /**
    *   Base route handler
    *
    *  @param Request
    *  @return View
    */
    public function index(Request $request)
    {
        
        // dd($request->user()->id) : spits out current user's id
        // \DB::enableQueryLog();
        // listGroups($request->user()->id);
        // dd(\DB::getQueryLog());
        $contacts = Contact::where(function ($query) use ($request) {
                $query->where('user_id', $request->user()->id);

            if ($group_id = ($request->get('group_id'))) {
                $query->where('group_id', $group_id);
            }
            //TODO: Extend the query for searching, not reset the query
            if ($term = $request->get("term")) {
                $keywords =  '%'.$term.'%';
                $query->orWhere("name", "LIKE", $keywords);
                $query->orWhere("email", "LIKE", $keywords);
                $query->orWhere("company", "LIKE", $keywords);
            }
        })
                ->orderBy('id', 'desc')
                ->paginate($this->limit);
        return view('contacts.index', compact('contacts'));
    }

    /**
    *   Handle 'create' route to create new contacts
    *
    *  @return View
    */
    public function create()
    {
        return view('contacts.create');
    }

    /**
    *   Handle 'edit' route to edit existing contacts
    *
    *  @param string
    *  @return View
    */
    public function edit($id)
    {
        
        $contact = Contact::findOrFail($id);
        $this->authorize('modify', $contact);
        return view('contacts.edit', compact('contact'));
    }

    /**
    *   Store Eloquent model to database
    *
    *  @param Request
    *  @return View
    */
    public function store(Request $request)
    {

        $this->validate($request, $this->rules);

        $data = $this->getRequest($request);

        //TODO: modify to store photo
        // echo $request->file('photo')->getClientOriginalName();
        // exit;

        //TODO: automatically recognize user_id when storing new contacts
        Contact::create($request->all());

        return redirect('contacts')->with('message', 'Contact Saved!');
    }

    /**
    *   Fetch HTTP request and store photo, if it exists.
    *
    *  @param Request
    *  @return View
    */
    public function getRequest(Request $request)
    {
        $data = $request->all();

        if ($request->hasFile('photo')) {
            $photo      = $request->file('photo');
            $fileName   = $photo->getClientOriginalName();
            $destination = $this->upload_dir;
        }
    }

    /**
    *   Update contact's data and its associated photo
    *   in the database
    *
    *  @param string, Request
    *  @return View
    */
    public function update($id, Request $request)
    {
        $contact = Contact::findOrFail($id);
        $this->authorize('modify', $contact);

        $this->validate($request, $this->rules);


        $oldPhoto = $contact->photo;
        $contact->update($request->all());

        if ($oldPhoto !== $contact->photo) {
            $this->removePhoto($oldPhoto);
        }

        return redirect('contacts')->with('message', 'Contact Updated!');
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $this->authorize('modify', $contact);

        $contact->delete();

        //TODO
        $this->removePhoto($contact->photo);

        return redirect('contacts')->with('message', 'Contact Deleted!');
    }

    //TODO
    public function removePhoto($photo)
    {
        if (! empty($photo)) {
            $file_path = base_path().'/public/uploads'.'/'.$photo;

            if (file_exists($file_path)) {
                unlink ($file_path);
            }
        }
    }

    
    /**
    *  Spit out a number of matching entries as Eloquent objects
    *  which in turn are served as JSON 
    *
    *  @param Request
    *  @return Contact
    */
    public function autocomplete(Request $request)
    {
        if ( $request->ajax() ) {
            return Contact::select(['id','name as value'])->where(function ($query) use ($request) {
                //TODO: Extend the query for searching, not reset the query
                if ($term = $request->get("term")) {
                    $keywords =  '%'.$term.'%';
                    $query->orWhere("name", "LIKE", $keywords);
                    $query->orWhere("email", "LIKE", $keywords);
                    $query->orWhere("company", "LIKE", $keywords);
                }
            })
                    ->orderBy('name', 'asc')
                    ->take(5)
                    ->get();
        }
    }
}
