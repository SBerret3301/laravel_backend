<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    // عرض جميع المدفوعات
    public function index()
    {
        return Paiement::all();
    }

    // إضافة مدفوعات جديدة
    public function store(Request $request)
    {
        // التحقق من صحة البيانات
        $validated = $request->validate([
            'reservation_id' => 'required|exists:reservations,id', // تأكد من وجود الحجز
            'montant' => 'required|numeric', // تأكد من أن المبلغ هو رقم
            'date_paiement' => 'required|date', // تاريخ الدفع
            'statut' => 'required|string', // حالة الدفع
        ]);

        // إنشاء السجل الجديد للدفع
        $paiement = Paiement::create([
            'reservation_id' => $validated['reservation_id'],
            'montant' => $validated['montant'],
            'date_paiement' => $validated['date_paiement'],
            'statut' => $validated['statut'], // مثل "Succès" أو "Échoué"
        ]);

        // إرجاع استجابة بنجاح
        return response()->json(['message' => 'Paiement effectué avec succès!', 'paiement' => $paiement], 201);
    }

    // عرض تفاصيل دفع معين
    public function show($id)
    {
        $paiement = Paiement::findOrFail($id);
        return response()->json($paiement);
    }

    // تحديث حالة الدفع
    public function update(Request $request, $id)
    {
        $paiement = Paiement::findOrFail($id);

        // تحديث البيانات مع التحقق من صحتها
        $paiement->update($request->all());

        // إرجاع المدفوعات المحدثة
        return response()->json($paiement);
    }

    // حذف عملية دفع
    public function destroy($id)
    {
        $paiement = Paiement::findOrFail($id);
        $paiement->delete();

        // إرجاع استجابة بنجاح
        return response()->json(null, 204);
    }
}
