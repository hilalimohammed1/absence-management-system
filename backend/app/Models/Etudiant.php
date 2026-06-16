<?php

namespace App\Models;

/**
 * Backward-compatible alias for older API code.
 *
 * The active database table is `students`, not the old French `etudiants` table.
 */
class Etudiant extends Student
{
}
