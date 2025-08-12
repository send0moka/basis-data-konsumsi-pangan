<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property string $kd_kelompokbps
 * @property string $nm_kelompokbps
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TbKomoditibps> $komoditibps
 * @property-read int|null $komoditibps_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TransaksiSusenas> $transaksiSusenas
 * @property-read int|null $transaksi_susenas_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TbKelompokbps newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TbKelompokbps newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TbKelompokbps query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TbKelompokbps whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TbKelompokbps whereKdKelompokbps($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TbKelompokbps whereNmKelompokbps($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TbKelompokbps whereUpdatedAt($value)
 */
	class TbKelompokbps extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $kd_komoditibps
 * @property string $nm_komoditibps
 * @property string $kd_kelompokbps
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TbKelompokbps $kelompokbps
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TransaksiSusenas> $transaksiSusenas
 * @property-read int|null $transaksi_susenas_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TbKomoditibps newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TbKomoditibps newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TbKomoditibps query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TbKomoditibps whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TbKomoditibps whereKdKelompokbps($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TbKomoditibps whereKdKomoditibps($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TbKomoditibps whereNmKomoditibps($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TbKomoditibps whereUpdatedAt($value)
 */
	class TbKomoditibps extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $kd_kelompokbps
 * @property string $kd_komoditibps
 * @property int $tahun
 * @property numeric $konsumsi_kuantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TbKelompokbps $kelompokbps
 * @property-read \App\Models\TbKomoditibps $komoditibps
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiSusenas newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiSusenas newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiSusenas query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiSusenas whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiSusenas whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiSusenas whereKdKelompokbps($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiSusenas whereKdKomoditibps($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiSusenas whereKonsumsiKuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiSusenas whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiSusenas whereUpdatedAt($value)
 */
	class TransaksiSusenas extends \Eloquent {}
}

namespace App\Models{
/**
 * @method bool hasRole($role)
 * @method bool hasAnyRole($roles)
 * @method bool hasAllRoles($roles)
 * @method \Illuminate\Database\Eloquent\Collection getRoleNames()
 * @method \Illuminate\Database\Eloquent\Relations\BelongsToMany roles()
 * @method self assignRole($role)
 * @method self removeRole($role)
 * @method self syncRoles($roles)
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 */
	class User extends \Eloquent {}
}

