<if cond="{leg[mbr_mid]} == {_user[mid]}"><if cond="{leg[leg_etat]} == LEG_ETAT_VLG">Votre village </if>
<else>Votre légion </else> [b]{leg[leg_name]}[/b] <if cond="isset({leg[ratio_def]}) && {leg[ratio_def]} < 1">(Défense groupée à <math oper="{leg[ratio_def]}*100" /> %)</if>
</if>
<else>
<if cond="{leg[leg_etat]} == LEG_ETAT_VLG">Le village de </if>
<else>La légion de </else> [img]{SITE_URL}img/{leg[mbr_race]}/{leg[mbr_race]}.png[/img] [url={SITE_URL}member-view.html?mid={leg[mbr_mid]}]{leg[mbr_pseudo]}[/url] : [b]{leg[leg_name]}[/b]<if cond="isset({leg[ratio_def]}) && {leg[ratio_def]} < 1">(Défense groupée à <math oper="{leg[ratio_def]}*100" /> %)</if>
</else>
<if cond='{war_act} == "histo" && {leg[hro_vie]}'>menée par <bbimgunt type="{leg[hro_type]}" race="{leg[mbr_race]}" /> {leg[hro_nom]} (xp {leg[hro_xp]}) <if cond="!empty({leg[bonus]})"><bbimgcomp type="{leg[bonus]}" race="{leg[mbr_race]}" />
</if>
</if>

<if cond='{SITE_DEBUG}'><foreach cond="{leg[leg]} as {type} => {nb}">
<if cond="!isset({leg[hro_type]}) || {leg[hro_type]} != {type}"> {nb} <bbimgunt type="{type}" race="{leg[mbr_race]}" /> </if>
</foreach>
</if>

Pertes : <foreach cond="{leg[pertes][unt]} as {type} => {nb}"><if cond="!isset({leg[hro_type]}) || {leg[hro_type]} != {type}">
{nb} <bbimgunt type="{type}" race="{leg[mbr_race]}" /> </if></foreach>
<if cond="{leg[hro_vie]}"><bbimgunt type="{leg[hro_type]}" race="{leg[mbr_race]}" /> ({leg[pertes][hro_reste]} / {leg[hro_vie_conf]}) <if cond='{leg[pertes][hro_reste]} == 0'>[color=red]{leg[hro_nom]} a perdu {leg[pertes][deg_hro]} points de vie, il est mort au combat ![/color]</if>
<else>{leg[hro_nom]} a perdu {leg[pertes][deg_hro]} points de vie (reste {leg[pertes][hro_reste]}).</else></if>

<if cond='{war_act} == "war_atq" && {leg[hro_vie]} && !empty({leg[bonus]})'><include file="modules/comp/{leg[bonus]}.tpl" cache="1" cpt="{leg[comp]}" />
</if>

