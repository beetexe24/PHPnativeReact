import React from "react";

export default function Content({data})
{
    return data.length > 0 ?
    (
        <tbody>
            {data.map((row, index) => (
                <tr key={index} className="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {row.properties.email}
                    </th>
                    <td className="px-6 py-4">
                        {row.properties.firstname}
                    </td>
                    <td className="px-6 py-4">
                        {row.properties.lastname}
                    </td>
                    <td className="px-6 py-4">
                        {row.properties.createdate}
                    </td>
                    <td className="px-6 py-4">
                        {row.properties.hs_lifecyclestage_marketingqualifiedlead_date}
                    </td>
                </tr>
            ))}
        </tbody>
    )

    :

    (
        
        <tbody>
            <tr>
                <td scope="row" className="px-6 py-4 font-medium text-gray-400 whitespace-nowrap dark:text-white">
                No data
                </td>
            </tr>
        </tbody>
    )
}