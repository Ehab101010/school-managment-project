<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TeacherAttendance extends Model
{
    protected $table = 'teacher_attendance';

    protected $fillable = [
        'teacher_id', 'recorded_by', 'date', 'status',
    ];

    protected $casts = [
        'date' => 'date',
    ];

     public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'teacher_id');
    }

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by', 'user_id');
    }

     public static function effectiveAbsences(int $teacherId, ?string $month = null): array
    {
        $query = self::where('teacher_id', $teacherId);

        if ($month) {
            $start = $month . '-01';
            $end   = \Carbon\Carbon::parse($start)->endOfMonth()->format('Y-m-d');
            $query->whereBetween('date', [$start, $end]);
        }

        $present  = (clone $query)->where('status', 'present')->count();
        $absences = (clone $query)->where('status', 'absent')->count();
        $lates    = (clone $query)->where('status', 'late')->count();

         $lateAsAbsence  = intdiv($lates, 3);
        $remainingLates = $lates % 3;
        $totalAbsences  = $absences + $lateAsAbsence;

        return [
            'present'        => $present,
            'absences'       => $absences,
            'lates'          => $lates,
            'late_as_absent' => $lateAsAbsence,
            'remaining_late' => $remainingLates,
            'total_absences' => $totalAbsences,
        ];
    }

     public function scopePresent($q) { return $q->where('status', 'present'); }
    public function scopeAbsent($q)  { return $q->where('status', 'absent'); }
    public function scopeLate($q)    { return $q->where('status', 'late'); }
}