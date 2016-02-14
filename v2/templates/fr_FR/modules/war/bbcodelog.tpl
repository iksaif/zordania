<foreach cond="{race} as {race_id} =>{race_name}"><load file="race/{race_id}.config" /><load file="race/{race_id}.descr.config" /></foreach>
Le {value[atq_date_formated]} <if cond="{value[atq_mid1]} == {_user[mid]}">Vous attaquez [url={SITE_URL}member-view.html?mid={value[atq_mid2]}]{value[mbr_pseudo2]}[/url]
</if>
<elseif cond="{value[atq_mid2]} == {_user[mid]}">Vous êtes attaqué par [url={SITE_URL}member-view.html?mid={value[atq_bilan][att][mbr_mid]}]{value[atq_bilan][att][mbr_pseudo]}[/url]
</elseif>
<else>[url={SITE_URL}member-view.html?mid={value[atq_bilan][att][mbr_mid]}]{value[atq_bilan][att][mbr_pseudo]}[/url] attaque votre allié [url={SITE_URL}member-view.html?mid={value[atq_mid2]}]{value[atq_bilan][def][{value[atq_lid2]}][mbr_pseudo]}[/url], vous prenez sa défense
</else>

<include file="modules/war/bbarmee.tpl" cache="1" leg="{value[atq_bilan][att]}" />
<include file="modules/war/bbarmee.tpl" cache="1" leg="{value[atq_bilan][def][{value[atq_lid2]}]}" />

[b]Légions en défense :[/b]
<foreach cond="{value[atq_bilan][def]} as {lid} => {leg}"><if cond="{lid} != {value[atq_lid2]}">
<include file="modules/war/bbarmee.tpl" cache="1" />
</if></foreach>
<set name="leg" value="{value[atq_bilan][def][{value[atq_lid2]}]}" />
<if cond="{value[atq_bilan][btc_def]}">
[b]Bâtiments défensifs :[/b]
<foreach cond="{value[atq_bilan][btc_def]} as {btc2} => {nb}">{nb} <bbimgbtc type="{btc2}" race="{leg[mbr_race]}" /> </foreach>
<if cond="isset({value[atq_bilan][btc_bonus][bon]})">Bonus fourni par les bâtiments = {value[atq_bilan][btc_bonus][bon]} % (y compris le donjon)
</if></if>
<if cond="{value[atq_bilan][btc_edit]}">[b]Bâtiments détruits :[/b]
<foreach cond="{value[atq_bilan][btc_edit]} as {btc2}"><if cond="{btc2[vie]} == 0">{btc2[vie]} / {btc2[vie_max]} <bbimgbtc type="{btc2[type]}" race="{leg[mbr_race]}" /> </if></foreach>
[b]Bâtiments endommagés :[/b]
<foreach cond="{value[atq_bilan][btc_edit]} as {btc2}"><if cond="{btc2[vie]} != 0">{btc2[vie]} / {btc2[vie_max]} <bbimgbtc type="{btc2[type]}" race="{leg[mbr_race]}" /> </if></foreach></if>

[b]Butin attaquant :[/b]
<foreach cond="{value[atq_bilan][butin][att]} as {type} => {nb}"><if cond="{nb}">{nb} <bbimgres type="{type}" race="{_user[race]}" /> </if></foreach> 	[color=green]{value[atq_bilan][att][xp_won]} XP gagnée par l'attaquant.[/color]
[b]Butin défenseur :[/b]
<foreach cond="{value[atq_bilan][butin][def]} as {type} => {nb}"><if cond="{nb}">{nb} <bbimgres type="{type}" race="{_user[race]}" /> </if></foreach> <foreach cond="{value[atq_bilan][def]} as {lid} => {leg}">
<if cond="{leg[leg_etat]} != LEG_ETAT_VLG">{leg[xp_won]} XP gagnée pour la légion {leg[leg_name]}</if>
</foreach>

