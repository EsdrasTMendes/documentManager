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
 * @property int $id
 * @property int $user_id
 * @property int $product_loan_id
 * @property string $file_path_docx
 * @property string $file_path_pdf
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ProductLoan $productLoan
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereFilePathDocx($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereFilePathPdf($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereProductLoanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereUserId($value)
 */
	class Document extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $brand
 * @property string $model
 * @property string $serial_number
 * @property string|null $processor
 * @property string|null $memory
 * @property string|null $disk
 * @property string $price
 * @property string $price_string
 * @property int $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ProductCategory|null $productCategory
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductLoanItem> $productLoanItem
 * @property-read int|null $product_loan_item_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereMemory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product wherePriceString($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProcessor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSerialNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUpdatedAt($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory whereUpdatedAt($value)
 */
	class ProductCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $loan_date
 * @property string $expected_return_date
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductLoanItem> $productLoanItems
 * @property-read int|null $product_loan_items_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLoan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLoan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLoan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLoan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLoan whereExpectedReturnDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLoan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLoan whereLoanDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLoan whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLoan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLoan whereUserId($value)
 */
	class ProductLoan extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $product_id
 * @property int $product_loan_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\ProductLoan $productLoan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLoanItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLoanItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLoanItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLoanItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLoanItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLoanItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductLoanItem whereProductLoanId($value)
 */
	class ProductLoanItem extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $role
 * @property string $email
 * @property string $cpf
 * @property string|null $phone_number
 * @property int $fl_active
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductLoan> $productLoans
 * @property-read int|null $product_loans_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCpf($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFlActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

