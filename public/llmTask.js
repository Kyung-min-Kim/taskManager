const openaiApiKey = "";
async function handleNaturalInput(event) {
  event.preventDefault();

  const userInput = document.getElementById("naturalInput").value;
  if (!userInput.trim()) {
    alert("Please enter a task.");
    return;
  }

  try {
    const response = await fetch("https://api.openai.com/v1/chat/completions", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${openaiApiKey}`,
      },
      body: JSON.stringify({
        model: "gpt-4o",
        messages: [
          {
            role: "system",
            content: `Please separate the user's input describing a task into a JSON object with "title" and "description" fields. Respond only with a valid JSON object without any markdown or code block formatting.`,
          },
          {
            role: "user",
            content: `Task: ${userInput}`,
          },
        ],
        temperature: 0.3,
      }),
    });

    const data = await response.json();
    if (!data.choices || !data.choices[0]?.message?.content) {
      throw new Error("Invalid response from OpenAI API.");
    }

    const rawContent = data.choices[0].message.content;
    const cleanedContent = rawContent
      .replace(/```json/g, "")
      .replace(/```/g, "")
      .trim();

    const parsed = JSON.parse(cleanedContent);
    if (!parsed.title || !parsed.description) {
      throw new Error("Parsed JSON does not contain title or description.");
    }

    document.getElementById("title").value = parsed.title;
    const descInput = document.querySelector(
      'form.inputForm input[name="description"]'
    );
    if (descInput) {
      descInput.value = parsed.description;
    }

    document.querySelector("form.inputForm").submit();
  } catch (error) {
    console.error("Error:", error);
    alert("An error occurred. Please check the console for details.");
  }
}
