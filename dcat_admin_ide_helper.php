<?php

/**
 * A helper file for Dcat Admin, to provide autocomplete information to your IDE
 *
 * This file should not be included in your code, only analyzed by your IDE!
 *
 * @author jqh <841324345@qq.com>
 */
namespace Dcat\Admin {
    use Illuminate\Support\Collection;

    /**
     * @property Grid\Column|Collection stocks
     * @property Grid\Column|Collection script
     * @property Grid\Column|Collection id
     * @property Grid\Column|Collection name
     * @property Grid\Column|Collection type
     * @property Grid\Column|Collection version
     * @property Grid\Column|Collection detail
     * @property Grid\Column|Collection created_at
     * @property Grid\Column|Collection updated_at
     * @property Grid\Column|Collection is_enabled
     * @property Grid\Column|Collection parent_id
     * @property Grid\Column|Collection order
     * @property Grid\Column|Collection icon
     * @property Grid\Column|Collection uri
     * @property Grid\Column|Collection extension
     * @property Grid\Column|Collection permission_id
     * @property Grid\Column|Collection menu_id
     * @property Grid\Column|Collection slug
     * @property Grid\Column|Collection http_method
     * @property Grid\Column|Collection http_path
     * @property Grid\Column|Collection role_id
     * @property Grid\Column|Collection user_id
     * @property Grid\Column|Collection value
     * @property Grid\Column|Collection username
     * @property Grid\Column|Collection password
     * @property Grid\Column|Collection avatar
     * @property Grid\Column|Collection remember_token
     * @property Grid\Column|Collection asn_item_id
     * @property Grid\Column|Collection sku_id
     * @property Grid\Column|Collection inventory_id
     * @property Grid\Column|Collection receive_qty
     * @property Grid\Column|Collection receive_at
     * @property Grid\Column|Collection confirm_at
     * @property Grid\Column|Collection put_away_at
     * @property Grid\Column|Collection location_id
     * @property Grid\Column|Collection deleted_at
     * @property Grid\Column|Collection asn_id
     * @property Grid\Column|Collection batch
     * @property Grid\Column|Collection estimated_qty
     * @property Grid\Column|Collection received_qty
     * @property Grid\Column|Collection put_away_qty
     * @property Grid\Column|Collection uuid
     * @property Grid\Column|Collection asn_number
     * @property Grid\Column|Collection status
     * @property Grid\Column|Collection eta_at
     * @property Grid\Column|Collection ata_at
     * @property Grid\Column|Collection remarks
     * @property Grid\Column|Collection sign_in_at
     * @property Grid\Column|Collection start_receive_at
     * @property Grid\Column|Collection invoice_tax_number
     * @property Grid\Column|Collection connection
     * @property Grid\Column|Collection queue
     * @property Grid\Column|Collection payload
     * @property Grid\Column|Collection exception
     * @property Grid\Column|Collection failed_at
     * @property Grid\Column|Collection order_id
     * @property Grid\Column|Collection condition
     * @property Grid\Column|Collection allocate_at
     * @property Grid\Column|Collection pick_wave_at
     * @property Grid\Column|Collection pick_at
     * @property Grid\Column|Collection pack_at
     * @property Grid\Column|Collection sorting_at
     * @property Grid\Column|Collection second_sort_at
     * @property Grid\Column|Collection handover_at
     * @property Grid\Column|Collection code
     * @property Grid\Column|Collection location_shelf_id
     * @property Grid\Column|Collection size
     * @property Grid\Column|Collection color
     * @property Grid\Column|Collection shape
     * @property Grid\Column|Collection light_type
     * @property Grid\Column|Collection icons
     * @property Grid\Column|Collection notes
     * @property Grid\Column|Collection order_number
     * @property Grid\Column|Collection order_date
     * @property Grid\Column|Collection quantity
     * @property Grid\Column|Collection tracking_number
     * @property Grid\Column|Collection delivery_date
     * @property Grid\Column|Collection order_data
     * @property Grid\Column|Collection images
     * @property Grid\Column|Collection receive_name
     * @property Grid\Column|Collection receive_phone
     * @property Grid\Column|Collection receive_address
     * @property Grid\Column|Collection design_images
     * @property Grid\Column|Collection email
     * @property Grid\Column|Collection token
     * @property Grid\Column|Collection tokenable_type
     * @property Grid\Column|Collection tokenable_id
     * @property Grid\Column|Collection abilities
     * @property Grid\Column|Collection last_used_at
     * @property Grid\Column|Collection category_id
     * @property Grid\Column|Collection barcode
     * @property Grid\Column|Collection qty
     * @property Grid\Column|Collection email_verified_at
     *
     * @method Grid\Column|Collection stocks(string $label = null)
     * @method Grid\Column|Collection script(string $label = null)
     * @method Grid\Column|Collection id(string $label = null)
     * @method Grid\Column|Collection name(string $label = null)
     * @method Grid\Column|Collection type(string $label = null)
     * @method Grid\Column|Collection version(string $label = null)
     * @method Grid\Column|Collection detail(string $label = null)
     * @method Grid\Column|Collection created_at(string $label = null)
     * @method Grid\Column|Collection updated_at(string $label = null)
     * @method Grid\Column|Collection is_enabled(string $label = null)
     * @method Grid\Column|Collection parent_id(string $label = null)
     * @method Grid\Column|Collection order(string $label = null)
     * @method Grid\Column|Collection icon(string $label = null)
     * @method Grid\Column|Collection uri(string $label = null)
     * @method Grid\Column|Collection extension(string $label = null)
     * @method Grid\Column|Collection permission_id(string $label = null)
     * @method Grid\Column|Collection menu_id(string $label = null)
     * @method Grid\Column|Collection slug(string $label = null)
     * @method Grid\Column|Collection http_method(string $label = null)
     * @method Grid\Column|Collection http_path(string $label = null)
     * @method Grid\Column|Collection role_id(string $label = null)
     * @method Grid\Column|Collection user_id(string $label = null)
     * @method Grid\Column|Collection value(string $label = null)
     * @method Grid\Column|Collection username(string $label = null)
     * @method Grid\Column|Collection password(string $label = null)
     * @method Grid\Column|Collection avatar(string $label = null)
     * @method Grid\Column|Collection remember_token(string $label = null)
     * @method Grid\Column|Collection asn_item_id(string $label = null)
     * @method Grid\Column|Collection sku_id(string $label = null)
     * @method Grid\Column|Collection inventory_id(string $label = null)
     * @method Grid\Column|Collection receive_qty(string $label = null)
     * @method Grid\Column|Collection receive_at(string $label = null)
     * @method Grid\Column|Collection confirm_at(string $label = null)
     * @method Grid\Column|Collection put_away_at(string $label = null)
     * @method Grid\Column|Collection location_id(string $label = null)
     * @method Grid\Column|Collection deleted_at(string $label = null)
     * @method Grid\Column|Collection asn_id(string $label = null)
     * @method Grid\Column|Collection batch(string $label = null)
     * @method Grid\Column|Collection estimated_qty(string $label = null)
     * @method Grid\Column|Collection received_qty(string $label = null)
     * @method Grid\Column|Collection put_away_qty(string $label = null)
     * @method Grid\Column|Collection uuid(string $label = null)
     * @method Grid\Column|Collection asn_number(string $label = null)
     * @method Grid\Column|Collection status(string $label = null)
     * @method Grid\Column|Collection eta_at(string $label = null)
     * @method Grid\Column|Collection ata_at(string $label = null)
     * @method Grid\Column|Collection remarks(string $label = null)
     * @method Grid\Column|Collection sign_in_at(string $label = null)
     * @method Grid\Column|Collection start_receive_at(string $label = null)
     * @method Grid\Column|Collection invoice_tax_number(string $label = null)
     * @method Grid\Column|Collection connection(string $label = null)
     * @method Grid\Column|Collection queue(string $label = null)
     * @method Grid\Column|Collection payload(string $label = null)
     * @method Grid\Column|Collection exception(string $label = null)
     * @method Grid\Column|Collection failed_at(string $label = null)
     * @method Grid\Column|Collection order_id(string $label = null)
     * @method Grid\Column|Collection condition(string $label = null)
     * @method Grid\Column|Collection allocate_at(string $label = null)
     * @method Grid\Column|Collection pick_wave_at(string $label = null)
     * @method Grid\Column|Collection pick_at(string $label = null)
     * @method Grid\Column|Collection pack_at(string $label = null)
     * @method Grid\Column|Collection sorting_at(string $label = null)
     * @method Grid\Column|Collection second_sort_at(string $label = null)
     * @method Grid\Column|Collection handover_at(string $label = null)
     * @method Grid\Column|Collection code(string $label = null)
     * @method Grid\Column|Collection location_shelf_id(string $label = null)
     * @method Grid\Column|Collection size(string $label = null)
     * @method Grid\Column|Collection color(string $label = null)
     * @method Grid\Column|Collection shape(string $label = null)
     * @method Grid\Column|Collection light_type(string $label = null)
     * @method Grid\Column|Collection icons(string $label = null)
     * @method Grid\Column|Collection notes(string $label = null)
     * @method Grid\Column|Collection order_number(string $label = null)
     * @method Grid\Column|Collection order_date(string $label = null)
     * @method Grid\Column|Collection quantity(string $label = null)
     * @method Grid\Column|Collection tracking_number(string $label = null)
     * @method Grid\Column|Collection delivery_date(string $label = null)
     * @method Grid\Column|Collection order_data(string $label = null)
     * @method Grid\Column|Collection images(string $label = null)
     * @method Grid\Column|Collection receive_name(string $label = null)
     * @method Grid\Column|Collection receive_phone(string $label = null)
     * @method Grid\Column|Collection receive_address(string $label = null)
     * @method Grid\Column|Collection design_images(string $label = null)
     * @method Grid\Column|Collection email(string $label = null)
     * @method Grid\Column|Collection token(string $label = null)
     * @method Grid\Column|Collection tokenable_type(string $label = null)
     * @method Grid\Column|Collection tokenable_id(string $label = null)
     * @method Grid\Column|Collection abilities(string $label = null)
     * @method Grid\Column|Collection last_used_at(string $label = null)
     * @method Grid\Column|Collection category_id(string $label = null)
     * @method Grid\Column|Collection barcode(string $label = null)
     * @method Grid\Column|Collection qty(string $label = null)
     * @method Grid\Column|Collection email_verified_at(string $label = null)
     */
    class Grid {}

    class MiniGrid extends Grid {}

    /**
     * @property Show\Field|Collection stocks
     * @property Show\Field|Collection script
     * @property Show\Field|Collection id
     * @property Show\Field|Collection name
     * @property Show\Field|Collection type
     * @property Show\Field|Collection version
     * @property Show\Field|Collection detail
     * @property Show\Field|Collection created_at
     * @property Show\Field|Collection updated_at
     * @property Show\Field|Collection is_enabled
     * @property Show\Field|Collection parent_id
     * @property Show\Field|Collection order
     * @property Show\Field|Collection icon
     * @property Show\Field|Collection uri
     * @property Show\Field|Collection extension
     * @property Show\Field|Collection permission_id
     * @property Show\Field|Collection menu_id
     * @property Show\Field|Collection slug
     * @property Show\Field|Collection http_method
     * @property Show\Field|Collection http_path
     * @property Show\Field|Collection role_id
     * @property Show\Field|Collection user_id
     * @property Show\Field|Collection value
     * @property Show\Field|Collection username
     * @property Show\Field|Collection password
     * @property Show\Field|Collection avatar
     * @property Show\Field|Collection remember_token
     * @property Show\Field|Collection asn_item_id
     * @property Show\Field|Collection sku_id
     * @property Show\Field|Collection inventory_id
     * @property Show\Field|Collection receive_qty
     * @property Show\Field|Collection receive_at
     * @property Show\Field|Collection confirm_at
     * @property Show\Field|Collection put_away_at
     * @property Show\Field|Collection location_id
     * @property Show\Field|Collection deleted_at
     * @property Show\Field|Collection asn_id
     * @property Show\Field|Collection batch
     * @property Show\Field|Collection estimated_qty
     * @property Show\Field|Collection received_qty
     * @property Show\Field|Collection put_away_qty
     * @property Show\Field|Collection uuid
     * @property Show\Field|Collection asn_number
     * @property Show\Field|Collection status
     * @property Show\Field|Collection eta_at
     * @property Show\Field|Collection ata_at
     * @property Show\Field|Collection remarks
     * @property Show\Field|Collection sign_in_at
     * @property Show\Field|Collection start_receive_at
     * @property Show\Field|Collection invoice_tax_number
     * @property Show\Field|Collection connection
     * @property Show\Field|Collection queue
     * @property Show\Field|Collection payload
     * @property Show\Field|Collection exception
     * @property Show\Field|Collection failed_at
     * @property Show\Field|Collection order_id
     * @property Show\Field|Collection condition
     * @property Show\Field|Collection allocate_at
     * @property Show\Field|Collection pick_wave_at
     * @property Show\Field|Collection pick_at
     * @property Show\Field|Collection pack_at
     * @property Show\Field|Collection sorting_at
     * @property Show\Field|Collection second_sort_at
     * @property Show\Field|Collection handover_at
     * @property Show\Field|Collection code
     * @property Show\Field|Collection location_shelf_id
     * @property Show\Field|Collection size
     * @property Show\Field|Collection color
     * @property Show\Field|Collection shape
     * @property Show\Field|Collection light_type
     * @property Show\Field|Collection icons
     * @property Show\Field|Collection notes
     * @property Show\Field|Collection order_number
     * @property Show\Field|Collection order_date
     * @property Show\Field|Collection quantity
     * @property Show\Field|Collection tracking_number
     * @property Show\Field|Collection delivery_date
     * @property Show\Field|Collection order_data
     * @property Show\Field|Collection images
     * @property Show\Field|Collection receive_name
     * @property Show\Field|Collection receive_phone
     * @property Show\Field|Collection receive_address
     * @property Show\Field|Collection design_images
     * @property Show\Field|Collection email
     * @property Show\Field|Collection token
     * @property Show\Field|Collection tokenable_type
     * @property Show\Field|Collection tokenable_id
     * @property Show\Field|Collection abilities
     * @property Show\Field|Collection last_used_at
     * @property Show\Field|Collection category_id
     * @property Show\Field|Collection barcode
     * @property Show\Field|Collection qty
     * @property Show\Field|Collection email_verified_at
     *
     * @method Show\Field|Collection stocks(string $label = null)
     * @method Show\Field|Collection script(string $label = null)
     * @method Show\Field|Collection id(string $label = null)
     * @method Show\Field|Collection name(string $label = null)
     * @method Show\Field|Collection type(string $label = null)
     * @method Show\Field|Collection version(string $label = null)
     * @method Show\Field|Collection detail(string $label = null)
     * @method Show\Field|Collection created_at(string $label = null)
     * @method Show\Field|Collection updated_at(string $label = null)
     * @method Show\Field|Collection is_enabled(string $label = null)
     * @method Show\Field|Collection parent_id(string $label = null)
     * @method Show\Field|Collection order(string $label = null)
     * @method Show\Field|Collection icon(string $label = null)
     * @method Show\Field|Collection uri(string $label = null)
     * @method Show\Field|Collection extension(string $label = null)
     * @method Show\Field|Collection permission_id(string $label = null)
     * @method Show\Field|Collection menu_id(string $label = null)
     * @method Show\Field|Collection slug(string $label = null)
     * @method Show\Field|Collection http_method(string $label = null)
     * @method Show\Field|Collection http_path(string $label = null)
     * @method Show\Field|Collection role_id(string $label = null)
     * @method Show\Field|Collection user_id(string $label = null)
     * @method Show\Field|Collection value(string $label = null)
     * @method Show\Field|Collection username(string $label = null)
     * @method Show\Field|Collection password(string $label = null)
     * @method Show\Field|Collection avatar(string $label = null)
     * @method Show\Field|Collection remember_token(string $label = null)
     * @method Show\Field|Collection asn_item_id(string $label = null)
     * @method Show\Field|Collection sku_id(string $label = null)
     * @method Show\Field|Collection inventory_id(string $label = null)
     * @method Show\Field|Collection receive_qty(string $label = null)
     * @method Show\Field|Collection receive_at(string $label = null)
     * @method Show\Field|Collection confirm_at(string $label = null)
     * @method Show\Field|Collection put_away_at(string $label = null)
     * @method Show\Field|Collection location_id(string $label = null)
     * @method Show\Field|Collection deleted_at(string $label = null)
     * @method Show\Field|Collection asn_id(string $label = null)
     * @method Show\Field|Collection batch(string $label = null)
     * @method Show\Field|Collection estimated_qty(string $label = null)
     * @method Show\Field|Collection received_qty(string $label = null)
     * @method Show\Field|Collection put_away_qty(string $label = null)
     * @method Show\Field|Collection uuid(string $label = null)
     * @method Show\Field|Collection asn_number(string $label = null)
     * @method Show\Field|Collection status(string $label = null)
     * @method Show\Field|Collection eta_at(string $label = null)
     * @method Show\Field|Collection ata_at(string $label = null)
     * @method Show\Field|Collection remarks(string $label = null)
     * @method Show\Field|Collection sign_in_at(string $label = null)
     * @method Show\Field|Collection start_receive_at(string $label = null)
     * @method Show\Field|Collection invoice_tax_number(string $label = null)
     * @method Show\Field|Collection connection(string $label = null)
     * @method Show\Field|Collection queue(string $label = null)
     * @method Show\Field|Collection payload(string $label = null)
     * @method Show\Field|Collection exception(string $label = null)
     * @method Show\Field|Collection failed_at(string $label = null)
     * @method Show\Field|Collection order_id(string $label = null)
     * @method Show\Field|Collection condition(string $label = null)
     * @method Show\Field|Collection allocate_at(string $label = null)
     * @method Show\Field|Collection pick_wave_at(string $label = null)
     * @method Show\Field|Collection pick_at(string $label = null)
     * @method Show\Field|Collection pack_at(string $label = null)
     * @method Show\Field|Collection sorting_at(string $label = null)
     * @method Show\Field|Collection second_sort_at(string $label = null)
     * @method Show\Field|Collection handover_at(string $label = null)
     * @method Show\Field|Collection code(string $label = null)
     * @method Show\Field|Collection location_shelf_id(string $label = null)
     * @method Show\Field|Collection size(string $label = null)
     * @method Show\Field|Collection color(string $label = null)
     * @method Show\Field|Collection shape(string $label = null)
     * @method Show\Field|Collection light_type(string $label = null)
     * @method Show\Field|Collection icons(string $label = null)
     * @method Show\Field|Collection notes(string $label = null)
     * @method Show\Field|Collection order_number(string $label = null)
     * @method Show\Field|Collection order_date(string $label = null)
     * @method Show\Field|Collection quantity(string $label = null)
     * @method Show\Field|Collection tracking_number(string $label = null)
     * @method Show\Field|Collection delivery_date(string $label = null)
     * @method Show\Field|Collection order_data(string $label = null)
     * @method Show\Field|Collection images(string $label = null)
     * @method Show\Field|Collection receive_name(string $label = null)
     * @method Show\Field|Collection receive_phone(string $label = null)
     * @method Show\Field|Collection receive_address(string $label = null)
     * @method Show\Field|Collection design_images(string $label = null)
     * @method Show\Field|Collection email(string $label = null)
     * @method Show\Field|Collection token(string $label = null)
     * @method Show\Field|Collection tokenable_type(string $label = null)
     * @method Show\Field|Collection tokenable_id(string $label = null)
     * @method Show\Field|Collection abilities(string $label = null)
     * @method Show\Field|Collection last_used_at(string $label = null)
     * @method Show\Field|Collection category_id(string $label = null)
     * @method Show\Field|Collection barcode(string $label = null)
     * @method Show\Field|Collection qty(string $label = null)
     * @method Show\Field|Collection email_verified_at(string $label = null)
     */
    class Show {}

    /**
     
     */
    class Form {}

}

namespace Dcat\Admin\Grid {
    /**
     
     */
    class Column {}

    /**
     
     */
    class Filter {}
}

namespace Dcat\Admin\Show {
    /**
     
     */
    class Field {}
}
