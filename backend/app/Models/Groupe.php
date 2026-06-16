<?php

namespace App\Models;

/**
 * Backward-compatible alias for older API code.
 *
 * The active database table is `groups`, not the old French `groupes` table.
 */
class Groupe extends Group
{
}
