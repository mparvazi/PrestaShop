{**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 *}
{l s='Taxes:' d='Shop.Pdf' pdf='true'}<br/>

<table id="tax-tab" width="100%">
	<thead>
		<tr>
			<th class="header-right small">{l s='Base TE' d='Shop.Pdf' pdf='true'}</th>
			<th class="header-right small">{l s='Tax Rate' d='Shop.Pdf' pdf='true'}</th>
			<th class="header-right small">{l s='Tax Value' d='Shop.Pdf' pdf='true'}</th>
		</tr>
	</thead>
	<tbody>
		{assign var=has_line value=false}

		{foreach $tax_order_summary as $entry}
			{assign var=has_line value=true}
			<tr>
				<td class="text-end white">{$currency->prefix} {$entry['base_te']} {$currency->suffix}</td>
				<td class="text-end white">{$entry['tax_rate']}</td>
				<td class="text-end white">{$currency->prefix} {$entry['total_tax_value']} {$currency->suffix}</td>
			</tr>
		{/foreach}

		{if !$has_line}
		<tr>
			<td class="white center" colspan="3">
				{l s='No taxes' d='Shop.Pdf' pdf='true'}
			</td>
		</tr>
		{/if}

	</tbody>
</table>
