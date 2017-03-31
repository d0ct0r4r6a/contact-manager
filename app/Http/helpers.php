<?php

function listGroups($userId){
  return DB::table('groups')
          ->select('groups.*', DB::raw('count(contacts.id) as total'))
          ->join('contacts', 'contacts.group_id', '=', 'groups.id')
          ->where('contacts.user_id', $userId)
          ->groupBy('contacts.group_id') 
          ->get();
}