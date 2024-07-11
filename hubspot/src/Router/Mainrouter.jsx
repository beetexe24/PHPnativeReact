import { Routes, Route } from "react-router-dom";
import Index from "../Components/Views";
import NotFound from "../Components/Views/NotFound";
import Master from "../Components/Layout/User/Master";

export default function Mainrouter()
{
    return (
        <Routes>
                <Route path="/" element={<Master />}  >
                    <Route path="/" element={<Index />} />
                </Route>
            
            <Route path="*" element={<NotFound />}/>
        </Routes>
    )
}