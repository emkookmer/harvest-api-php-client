<?php
/**
 * InvoiceItemCategories class.
 */

namespace Required\Harvest\Api;

use DateTime;
use Http\Client\Exception;
use Required\Harvest\Exception\InvalidArgumentException;
use Required\Harvest\Exception\MissingArgumentException;
use Required\Harvest\Exception\RuntimeException;

/**
 * API client for invoice item categories endpoint.
 *
 * @link https://help.getharvest.com/api-v2/invoices-api/invoices/invoice-item-categories/
 */
class InvoiceItemCategories extends AbstractApi implements InvoiceItemCategoriesInterface {


	/**
	 * Retrieves a list of invoice item categories.
	 *
	 * @param array $parameters {
	 *     Optional. Parameters for filtering the list of invoice item categories. Default empty array.
	 *
	 *     @type DateTime|string $updated_since Only return invoice item categories that have been updated since
	 *                                           the given date and time.
	 * }
	 * @return array|string
	 * @throws Exception
	 */
	public function all( array $parameters = [] ) {
		if ( isset( $parameters['updated_since'] ) && $parameters['updated_since'] instanceof DateTime ) {
			$parameters['updated_since'] = $parameters['updated_since']->format( DateTime::ATOM );
		}

		$result = $this->get( '/invoice_item_categories', $parameters );
		if ( ! isset( $result['invoice_item_categories'] ) || ! is_array( $result['invoice_item_categories'] ) ) {
			throw new RuntimeException( 'Unexpected result.' );
		}

		return $result['invoice_item_categories'];
	}

	/**
	 * Retrieves the invoice item category with the given ID.
	 *
	 * @param int $invoiceItemCategoryId The ID of the invoice item category.
	 * @return array|string
	 * @throws Exception
	 */
	public function show( int $invoiceItemCategoryId ) {
		return $this->get( '/invoice_item_categories/' . rawurlencode( $invoiceItemCategoryId ) );
	}

	/**
	 * Creates a new invoice item category object.
	 *
	 * @throws Exception
	 * @throws MissingArgumentException
	 * @throws InvalidArgumentException
	 *
	 * @param array $parameters The parameters of the new invoice item category object.
	 * @return array|string
	 */
	public function create( array $parameters ) {
		if ( ! isset( $parameters['name'] ) ) {
			throw new MissingArgumentException( 'name' );
		}

		if ( ! is_string( $parameters['name'] ) || empty( trim( $parameters['name'] ) ) ) {
			throw new InvalidArgumentException( 'The "name" parameter must be a non-empty string.' );
		}

		return $this->post( '/invoice_item_categories', $parameters );
	}

	/**
	 * Updates the specific invoice item category by setting the values of the parameters passed.
	 *
	 * Any parameters not provided will be left unchanged.
	 *
	 * @param int $invoiceItemCategoryId The ID of the invoice item category.
	 * @param array $parameters
	 * @return array|string
	 * @throws Exception
	 */
	public function update( int $invoiceItemCategoryId, array $parameters ) {
		return $this->patch( '/invoice_item_categories/' . rawurlencode( $invoiceItemCategoryId ), $parameters );
	}

	/**
	 * Deletes an invoice item category.
	 *
	 * Deleting an invoice item category is only possible if `use_as_service` and `use_as_expense` are both false.
	 *
	 * @param int $invoiceItemCategoryId The ID of the invoice item category.
	 * @return array|string
	 * @throws Exception
	 */
	public function remove( int $invoiceItemCategoryId ) {
		return $this->delete( '/invoice_item_categories/' . rawurlencode( $invoiceItemCategoryId ) );
	}
}
