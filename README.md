# profinsubmitbackend
Backend Code



  public function menu($menu_id, $lang = '')
    {
        if ($menu_id > 0) {
            // Get menu details
            $Menu = Menu::where('father_id', $menu_id)->where('status', 1)->orderby('row_no', 'asc')->get();
            if (count($Menu) > 0) {
                // By Language
                $lang = $this->getLanguage($lang);
                $title_var = "title_$lang";

                // Response Details
                $response_details = [];
                foreach ($Menu as $MenuLink) {
                    $SubMenu = Menu::where('father_id', $MenuLink->id)->where('status', 1)->orderby('row_no', 'asc')->get();
                    $sub_response_details = [];
                    if (count($SubMenu) > 0) {
                        foreach ($SubMenu as $SubMenuLink) {
                            $m_link = "";
                            if ($SubMenuLink->type == 3 || $SubMenuLink->type == 2) {
                                $m_link = $SubMenuLink->webmasterSection->name;
                            } elseif ($SubMenuLink->type == 1) {
                                $m_link = $MenuLink->link;
                            }
                            $sub_response_details[] = [
                                'id' => $SubMenuLink->id,
                                'title' => $SubMenuLink->$title_var,
                                'section_id' => $SubMenuLink->cat_id,
                                'href' => $SubMenuLink->link_en
                            ];
                        }
                    }

                    $m_link = "";
                     $sub_count = count($SubMenu);
                    // if ($MenuLink->type == 3) {
                    //     // Section with drop list
                    //     $m_link = $MenuLink->webmasterSection->name;
                    //     $sub_count = count($MenuLink->webmasterSection->sections);
                    //     foreach ($MenuLink->webmasterSection->sections as $SubSection) {
                    //         $sub_response_details[] = [
                    //             'id' => $SubSection->id,
                    //             'title' => $SubSection->$title_var,
                    //             'section_id' => $MenuLink->cat_id,
                    //             'href' => "topics/cat/" . $SubSection->id
                    //         ];
                    //     }
                    // } elseif ($MenuLink->type == 2) {
                    //     // Section Link
                    //     $m_link = $MenuLink->webmasterSection->name;
                    // } elseif ($MenuLink->type == 1) {
                        $m_link = $MenuLink->link_en;
                    // }
                    // echo'<pre>';print_r( $m_link);exit;
                   
                    $response_details[] = [
                        'id' => $MenuLink->id,
                        'title' => $MenuLink->$title_var,
                        'section_id' => $MenuLink->cat_id,
                        'href' => $m_link,
                        'sub_links_count' => $sub_count,
                        'sub_links' => $sub_response_details
                    ];
                    // sub links

                }
                // Response MSG
                $response = [
                    'msg' => 'List of Menu Links',
                    'links_count' => count($Menu),
                    'links' => $response_details
                ];
                return response()->json($response, 200);
            } else {
                // Empty MSG
                $response = [
                    'msg' => 'There is no data'
                ];
                return response()->json($response, 200);
            }
        } else {
            // Empty MSG
            $response = [
                'msg' => 'There is no data'
            ];
            return response()->json($response, 404);
        }
    }