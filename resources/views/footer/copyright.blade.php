<x-app-layout>
    <div class="bg-gray-100 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Copyright Policy</h3>
                    <p class="mt-1 max-w-full text-sm text-gray-500">At MangaGlobe, we respect the intellectual property rights of others and expect our users to do the same. This Copyright Policy outlines our practices for addressing claims of copyright infringement involving content uploaded to our platform.</p>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Copyright Ownership</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <p>1.1 MangaGlobe does not claim ownership of any copyrights in the manga or other content that our users upload to the platform. Copyright ownership remains with the respective rights holders.</p>
                                <p class="mt-2">1.2 By uploading content to MangaGlobe, users grant us a non-exclusive, worldwide license to reproduce, distribute, and display that content in connection with providing our services.</p>
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Copyright Infringement Claims</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <p>2.1 If you are a copyright owner or an authorized representative and believe that your copyrighted work has been infringed upon on MangaGlobe, you may submit a copyright infringement claim by providing the following information:</p>
                                <ul class="list-disc pl-5 mt-2">
                                    <li>A physical or electronic signature of the copyright owner or authorized representative.</li>
                                    <li>Identification of the copyrighted work claimed to have been infringed.</li>
                                    <li>Identification of the material on MangaGlobe that is claimed to be infringing, including its URL or other specific location details.</li>
                                    <li>Your contact information, including name, address, telephone number, and email address.</li>
                                    <li>A statement by you that you have a good faith belief that the use of the material is not authorized by the copyright owner, its agent, or the law.</li>
                                    <li>A statement by you, made under penalty of perjury, that the information provided in your notice is accurate and that you are the copyright owner or authorized to act on the copyright owner's behalf.</li>
                                </ul>
                                <p class="mt-2">2.2 Copyright infringement claims should be submitted through our dedicated 
                                    <a href="{{ route('claim') }}" class="text-blue-500">copyright claim form</a>
                                </p>
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Response to Copyright Infringement Claims</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <p>3.1 Upon receiving a properly submitted copyright infringement claim, MangaGlobe will promptly investigate the claim and take appropriate actions, which may include removing or disabling access to the allegedly infringing material.</p>
                                <p class="mt-2">3.2 If MangaGlobe removes or disables access to material in response to a copyright infringement claim, we will make reasonable efforts to notify the user who uploaded the material.</p>
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Counter-Notices</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <p>4.1 If a user believes that their content was removed or disabled due to a mistake or misidentification, they may submit a counter-notice to MangaGlobe, providing the following information:</p>
                                <ul class="list-disc pl-5 mt-2">
                                    <li>Their physical or electronic signature.</li>
                                    <li>Identification of the material that was removed or disabled, including its URL or other specific location details.</li>
                                    <li>A statement under penalty of perjury that they have a good faith belief that the material was removed or disabled as a result of a mistake or misidentification of the material.</li>
                                    <li>Their name, address, and telephone number, and a statement that they consent to the jurisdiction of the relevant court and that they will accept service of process from the person who provided the copyright infringement claim.</li>
                                </ul>
                                <p class="mt-2">4.2 Upon receiving a properly submitted counter-notice, MangaGlobe may restore access to the removed or disabled material after a designated waiting period, unless we receive notification that legal action has been initiated related to the material.</p>
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Repeat Infringers</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <p>MangaGlobe reserves the right to terminate the accounts of users who are found to be repeat infringers of copyrights or other intellectual property rights.</p>
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Fair Use and Parody</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <p>MangaGlobe recognizes fair use and parody exceptions to copyright infringement under applicable laws. We may consider such exceptions when evaluating infringement claims.</p>
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Contact Information</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <p>If you have any questions or concerns about this Copyright Policy, please <a href="{{ route('contact.create') }}" class="text-blue-500">contact us</a>.</p>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>