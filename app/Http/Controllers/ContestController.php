<?php
namespace App\Http\Controllers;

use App\Models\Contest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ContestController extends Controller
{
    public function contest(Request $request)
    {
        
        $valid = Validator::make($request->all(), [
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone' => 'required|regex:/^\d{3}-\d{3}-\d{3}$/',
            'email' => 'required|email|max:100',
            'receipt_number' => 'required|string|max:50',
            'purchase_date' => 'required|date_format:d-m-Y|before_or_equal:today|after_or_equal:2024-06-15',
            'receipt_image' => 'nullable|image|max:5120',
            'terms_accepted' => 'required|boolean',
            'marketing_accepted' => 'boolean',
        ],
        [
            'first_name.required' => 'Imię jest wymagane.',
            'first_name.string' => 'Imię musi być ciągiem znaków.',
            'first_name.max' => 'Imię nie może przekraczać 50 znaków.',
            
            'last_name.required' => 'Nazwisko jest wymagane.',
            'last_name.string' => 'Nazwisko musi być ciągiem znaków.',
            'last_name.max' => 'Nazwisko nie może przekraczać 50 znaków.',
            
            'phone.required' => 'Numer telefonu jest wymagany.',
            'phone.regex' => 'Numer telefonu musi być w formacie 123-456-789.',
            
            'email.required' => 'Adres e-mail jest wymagany.',
            'email.email' => 'Podany adres e-mail jest nieprawidłowy.',
            'email.max' => 'Adres e-mail nie może przekraczać 100 znaków.',
            
            'receipt_number.required' => 'Numer paragonu jest wymagany.',
            'receipt_number.string' => 'Numer paragonu musi być ciągiem znaków.',
            'receipt_number.max' => 'Numer paragonu nie może przekraczać 50 znaków.',
            
            'purchase_date.required' => 'Data zakupu jest wymagana.',
            'purchase_date.date_format' => 'Data zakupu musi być w formacie d-m-Y.',
            'purchase_date.before_or_equal' => 'Data zakupu musi być dzisiaj lub wcześniejsza.',
            'purchase_date.after_or_equal' => 'Data zakupu musi być po 15 czerwca 2024.',
            
            'receipt_image.image' => 'Obrazek paragonu musi być obrazem.',
            'receipt_image.max' => 'Obrazek paragonu nie może przekraczać 5MB.',
            'receipt_image.uploaded' => 'Obrazek paragonu nie udało się przesłać.',
            
            'terms_accepted.required' => 'Musisz zaakceptować warunki.',
            'terms_accepted.boolean' => 'Akceptacja warunków musi być wartością logiczną.',
            
            'marketing_accepted.boolean' => 'Akceptacja marketingu musi być wartością logiczną.',
        ]);

        if ($valid->fails()) {
            return response()->json($valid->errors(), 422);
        }
        
        $receiptImagePath = $this->storeReceiptImage($request);
        
        $contest = Contest::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'receipt_number' => $request->receipt_number,
            'purchase_date' => \Carbon\Carbon::createFromFormat('d-m-Y', $request->purchase_date),
            'receipt_image' => $receiptImagePath,
            'terms_accepted' => $request->terms_accepted,
            'marketing_accepted' => $request->marketing_accepted,
        ]);

        return response()->json($contest, 201);
    }

    private function storeReceiptImage(Request $request)
    {
        $receiptImagePath = null;

        if ($request->hasFile('receipt_image')) {
            $receiptImagePath = $request->file('receipt_image')->store('receipts');
        }
        return $receiptImagePath;
    }
}
