Votre légion partie en guerre chez <img src="img/groupes/{vars[mbr_gid]}.png" alt="{groupes[{vars[mbr_gid]}]}" title="{groupes[{vars[mbr_gid]}]}"/> {vars[mbr_pseudo]}
est maintenant de retour dans votre village ! 
<if cond="|{vars[histo_var1]}| or |{vars[histo_var3]}|">
Votre butin est amené au donjon:
<if cond="{vars[histo_var1]}">{vars[histo_var1]}<img src="img/{session_user[race]}/res/{vars[histo_var2]}.png" alt="{res[{session_user[race]}][alt][{vars[histo_var2]}]}" title="{res[{session_user[race]}][alt][{vars[histo_var2]}]}" /> </if>
<if cond="{vars[histo_var3]}">{vars[histo_var3]}<img src="img/{session_user[race]}/res/{vars[histo_var4]}.png" alt="{res[{session_user[race]}][alt][{vars[histo_var4]}]}" title="{res[{session_user[race]}][alt][{vars[histo_var4]}]}" /> </if>
</if>
.