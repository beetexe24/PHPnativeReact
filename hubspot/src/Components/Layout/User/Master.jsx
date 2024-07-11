import { Outlet } from "react-router-dom";

export default function Master()
{
    return (
        <div className="bg-slate-50 min-h-screen relative flex flex-col">
            <Outlet />

        </div>
        
    )
}