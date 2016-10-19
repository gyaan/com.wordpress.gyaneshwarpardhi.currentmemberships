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
        <th>Member Name</th>
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
            <td>
                <a href="/civicrm/contact/view?reset=1&cid={$v.contact_id}">{$v.api_Contact_getsingle.sort_name}</a>
            </td>
            <td>{$v.membership_name}</td>
            <td>{$v.relationship_name}</td>
            <td>{$v.join_date|date_format}</td>
            <td>{$v.start_date|date_format}</td>
            <td>{$v.end_date|date_format}</td>
            <td>{$v.source}</td>
            <td>{$v.status_id}</td>
            <td>{if $v.is_test eq 1} Yes {else} No {/if}</td>
            <td>{if $v.is_pay_later eq 1} Yes {else} No {/if}</td>
        </tr>
    {/foreach}
    </tbody>
</table>
<a href="{crmURL p='civicrm/member/search' q='reset=1'}">&raquo; {ts}Find more members{/ts}...</a>

