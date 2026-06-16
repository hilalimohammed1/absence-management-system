<?php

namespace App\Models;

/**
 * Backward-compatible alias for older API code.
 *
 * The active database table is `attendances`, not the old French `absences` table.
 */
class Absence extends Attendance
{
}
