'use client'

import { useState } from 'react'
import { Bell, Menu, X } from 'lucide-react'
import { Button } from "@/components/ui/button"
import { Dialog, DialogContent, DialogHeader, DialogTitle } from "@/components/ui/dialog"
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table"

export default function Component() {
  const [showSidebar, setShowSidebar] = useState(true)
  const [showApplyModal, setShowApplyModal] = useState(false)
  const [selectedScholarship, setSelectedScholarship] = useState<any>(null)

  const scholarships = [
    {
      type: "Academic Excellence",
      grade: "1st Year",
      lastDate: "November 15, 2024",
      publishedDate: "October 1, 2024",
      details: {
        gradeAndCampus: "1st Year BSU-Lipa",
        yearScholarship: "2024-2025",
        category: "Merit-based",
        criteria: "Applicants must have an overall average of 90% or above in their most recent academic year or term.",
        documents: "Birth Certificate, Report Card, Enrollment Form",
        description: "Rewards outstanding students who consistently achieve high grades",
        amount: "3000 pesos"
      }
    },
    {
      type: "Financial Assistance",
      grade: "All Year Levels",
      lastDate: "November 20, 2024",
      publishedDate: "October 5, 2024"
    },
    // Add more scholarships as needed
  ]

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Header */}
      <header className="bg-red-600 text-white p-4 flex items-center justify-between">
        <div className="flex items-center gap-4">
          <img src="/placeholder.svg" alt="Logo" className="w-12 h-12" />
          <h1 className="text-2xl font-bold">Scholarship Tracker System</h1>
        </div>
        <div className="flex items-center gap-4">
          <button className="relative">
            <Bell className="w-6 h-6" />
            <span className="absolute -top-1 -right-1 bg-white text-red-600 rounded-full w-5 h-5 text-xs flex items-center justify-center">
              2
            </span>
          </button>
          <div className="flex items-center gap-2">
            <img src="/placeholder.svg" alt="Profile" className="w-10 h-10 rounded-full" />
            <div>
              <span>Welcome</span>
              <h2 className="font-semibold">John Doe</h2>
            </div>
          </div>
        </div>
      </header>

      <div className="flex">
        {/* Sidebar */}
        <aside className={`bg-white w-64 min-h-[calc(100vh-80px)] shadow-lg transition-all duration-300 ${showSidebar ? 'translate-x-0' : '-translate-x-full'}`}>
          <nav className="p-4">
            <button onClick={() => setShowSidebar(!showSidebar)} className="md:hidden absolute right-4 top-4">
              <X className="w-6 h-6" />
            </button>
            <ul className="space-y-2">
              <li className="p-2 hover:bg-gray-100 rounded-lg">Dashboard</li>
              <li className="p-2 bg-red-600 text-white rounded-lg">View Schema</li>
              <li className="p-2 hover:bg-gray-100 rounded-lg">Application History</li>
              <li className="p-2 hover:bg-gray-100 rounded-lg">Profile</li>
              <li className="p-2 hover:bg-gray-100 rounded-lg">Settings</li>
              <li className="p-2 hover:bg-gray-100 rounded-lg">Logout</li>
            </ul>
          </nav>
        </aside>

        {/* Main Content */}
        <main className="flex-1 p-6">
          <div className="bg-white rounded-lg shadow p-6">
            <div className="flex justify-between items-center mb-6">
              <h2 className="text-2xl font-bold">View Scholarship Scheme</h2>
              <Button variant="ghost" size="icon" className="md:hidden" onClick={() => setShowSidebar(!showSidebar)}>
                <Menu className="w-6 h-6" />
              </Button>
            </div>

            <div className="overflow-x-auto">
              <Table>
                <TableHeader>
                  <TableRow>
                    <TableHead>Scholarship Type</TableHead>
                    <TableHead>Scholarship Grade</TableHead>
                    <TableHead>Last Date of submission</TableHead>
                    <TableHead>Published Date</TableHead>
                    <TableHead>Action</TableHead>
                  </TableRow>
                </TableHeader>
                <TableBody>
                  {scholarships.map((scholarship, index) => (
                    <TableRow key={index}>
                      <TableCell>{scholarship.type}</TableCell>
                      <TableCell>{scholarship.grade}</TableCell>
                      <TableCell>{scholarship.lastDate}</TableCell>
                      <TableCell>{scholarship.publishedDate}</TableCell>
                      <TableCell>
                        <Button
                          className="bg-violet-500 hover:bg-violet-600"
                          onClick={() => {
                            setSelectedScholarship(scholarship)
                            setShowApplyModal(true)
                          }}
                        >
                          VIEW DETAILS
                        </Button>
                      </TableCell>
                    </TableRow>
                  ))}
                </TableBody>
              </Table>
            </div>
          </div>
        </main>
      </div>

      {/* Apply Modal */}
      <Dialog open={showApplyModal} onOpenChange={setShowApplyModal}>
        <DialogContent className="max-w-md">
          <DialogHeader>
            <DialogTitle>Apply Now</DialogTitle>
          </DialogHeader>
          <form className="space-y-4">
            <div className="space-y-2">
              <Label htmlFor="photo">Photo:</Label>
              <Input id="photo" type="file" accept="image/*" />
            </div>
            <div className="space-y-2">
              <Label htmlFor="name">Name:</Label>
              <Input id="name" placeholder="John Doe" />
            </div>
            <div className="space-y-2">
              <Label htmlFor="dob">Date of birth:</Label>
              <Input id="dob" type="date" />
            </div>
            <div className="space-y-2">
              <Label htmlFor="gender">Gender:</Label>
              <Input id="gender" placeholder="Male" />
            </div>
            <div className="space-y-2">
              <Label htmlFor="mobile">Mobile no:</Label>
              <Input id="mobile" placeholder="09778455634" />
            </div>
            <div className="space-y-2">
              <Label htmlFor="application">Application no:</Label>
              <Input id="application" placeholder="98765" />
            </div>
            <div className="space-y-2">
              <Label htmlFor="email">Email:</Label>
              <Input id="email" type="email" placeholder="22-36298@g.batstate-u.edu.ph" />
            </div>
            <div className="space-y-2">
              <Label htmlFor="srcode">Sr-Code:</Label>
              <Input id="srcode" placeholder="22-36298" />
            </div>
            <div className="space-y-2">
              <Label htmlFor="year">Year Level:</Label>
              <Input id="year" placeholder="1st Year" />
            </div>
            <div className="space-y-2">
              <Label htmlFor="documents">Upload Required Doc:</Label>
              <Input id="documents" type="file" multiple />
            </div>
            <div className="flex justify-end gap-2">
              <Button variant="destructive" onClick={() => setShowApplyModal(false)}>
                Close
              </Button>
              <Button className="bg-violet-500 hover:bg-violet-600">
                Update
              </Button>
            </div>
          </form>
        </DialogContent>
      </Dialog>
    </div>
  )
}