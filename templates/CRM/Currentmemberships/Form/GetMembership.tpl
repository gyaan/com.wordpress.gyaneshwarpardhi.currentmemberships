{* HEADER *}

{*<div class="crm-submit-buttons">*}
{*{include file="CRM/common/formButtons.tpl" location="top"}*}
{*</div>*}

{* FIELD EXAMPLE: OPTION 1 (AUTOMATIC LAYOUT) *}
{foreach from=$elementNames item=elementName}
  <div class="crm-section">
    <div class="label">{$form.$elementName.label}</div>
    <div class="content">{$form.$elementName.html}</div>
    <div class="clear"></div>
  </div>
{/foreach}
<div class="crm-submit-buttons">
  {include file="CRM/common/formButtons.tpl" location="bottom"}
</div>
<div class="clear"></div>
<P><b>Total Number of membership:</b> {$membership.count}</P>
<table class="sticky-enabled table-select-processed tableheader-processed sticky-table">
  <thead>
  <tr>
    <th>Membership Name</th>
    <th>Relationship name</th>
    <th>Join Date</th>
    <th>Start Date</th>
    <th>End Date</th>
    <th>Source</th>
    <th>Status Id</th>
    <th>Is test</th>
    <th>Is pay later</th>
  </tr>
  </thead>
  <tbody>
  {foreach from=$membership.values key=k item=v}
    <tr>
      <td>{$v.membership_name}</td>
      <td>{$v.relationship_name}</td>
      <td>{$v.join_date}</td>
      <td>{$v.start_date}</td>
      <td>{$v.end_date}</td>
      <td>{$v.source}</td>
      <td>{$v.status_id}</td>
      <td>{$v.is_test}</td>
      <td>{$v.is_pay_later}</td>
    </tr>
  {/foreach}
  </tbody>
</table>



{* FIELD EXAMPLE: OPTION 2 (MANUAL LAYOUT)

  <div>
    <span>{$form.favorite_color.label}</span>
    <span>{$form.favorite_color.html}</span>
  </div>

{* FOOTER *}

