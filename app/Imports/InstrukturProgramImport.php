<?php

namespace App\Imports;

use App\Models\Course\MataInstruktur;
use App\Models\Course\MataPelatihan;
use App\Models\Users\User;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class InstrukturProgramImport implements
    ToModel,
    WithStartRow,
    WithHeadingRow,
    WithValidation,
    SkipsOnError,
    SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $mata = MataPelatihan::find(request()->segment(2));
        $email = $row['email'];

        if ($mata->program->tipe == 0) {
            $user = User::whereHas('roles', function ($query) {
                $query->where('id', 5);
            })->where('email', $email)->first();
        } else {
            $user = User::whereHas('roles', function ($query) {
                $query->where('id', 6);
            })->where('email', $email)->first();
        }

        if (!empty($user)) {
            $check = MataInstruktur::where('mata_id', request()->segment(2))
                ->where('instruktur_id', $user->instruktur->id)->count();
        } else {
            $check = 0;
        }

        if (!empty($user) && $check == 0) {
            $instruktur = new MataInstruktur;
            $instruktur->mata_id = request()->segment(2);
            $instruktur->instruktur_id = $user->instruktur->id;
            $instruktur->save();
        }
    }

    public function rules(): array
    {
        return [
            '*.nip' => 'required',
            '*.nama' => 'required',
            '*.email' => 'required|email',
        ];
    }

    public function customValidationAttributes()
    {
        return [
            'nip' => 'NIP',
            'nama' => 'nama',
            'email' => 'email',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nip.required' => ':attribute tidak boleh kosong',
            'nama.required' => ':attribute tidak boleh kosong',
            'email.required' => ':attribute tidak boleh kosong',
            'email.email' => ':attribute harus valid',
        ];
    }
}
